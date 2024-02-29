<?php

namespace App\Services;

use App\Models\Celebrant;
use App\OutputParser\JsonListParser;
use App\OutputParser\JsonPromParser;
use App\Prompts\Chat\SystemMessagePromptTemplate;
use App\Prompts\Chat\UserMessagePromptTemplate;
use App\Prompts\PromptTemplate;
use DiDom\Document;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use JsonException;



class GiftService
{
    public function generateGifts(Celebrant $celebrant)
    {
        Log::debug('start function generateGifts');
        $hobbies = collect($celebrant->hobbies()->pluck('name'))->implode(',');

        $prompt = PromptTemplate::create(template: 'Які ідеї подарунків для співробітника по імені {firstname} та прізвищу {lastname}, який народився {date}, 
        та працює в компанії {company} на посаді {position}. Має такі хобі як {hobbies}. 
        Зроби висновок якої статі іменинник та розрахуй вік іменинника. 
        Враховуючи стать, вік та хобі запропонуй варіанти подарунків. Не пропонуй дитячі товари.')
            ->format([
                '{firstname}' => $celebrant->firstname,
                '{lastname}' => $celebrant->lastname,
                '{date}' => $celebrant->birthday,
                '{company}' => $celebrant->company->name,
                '{position}' => $celebrant->position,
                '{hobbies}' => $hobbies,
            ])
            ->outputParser(new JsonListParser());

        $httpClient = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.chat_gpt'),
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $httpClient->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    SystemMessagePromptTemplate::fromString("
                    You are the manager of the company. You help choose a birthday gift for an colleague of your company.
                    Please follow the RESPONSE FORMAT INSTRUCTIONS when responding to the User.
                    "),
                    UserMessagePromptTemplate::fromString($prompt->toString()),
                ],
            ],
        ]);
        $results  = [];
        try {
            $gifts_AI = Arr::get(json_decode($response->getBody(), true, $depth = 512, JSON_THROW_ON_ERROR), 'choices.0.message.content', []);
            $gifts_AI = Arr::pluck(json_decode($gifts_AI, true, $depth = 512, JSON_THROW_ON_ERROR)['data'], 'gift name');
            $client   = new Client(['http_errors' => false,]);
            Log::debug('ChatGPT gift ideas: ' . json_encode($gifts_AI, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            foreach ($gifts_AI as $gift) {

                $request  = new Request('GET', 'https://prom.ua/ua/search');
                $response = $client->send($request, [
                    'query' => [
                        'search_term' => $gift,
                        'price_local__lte' => $celebrant->gift_budget,
                        // a496 - filter by age, 7818 - "adults", 9541 - "for adults"
                        'a496' => [7818, 9541],
                    ]
                ]);

                if (200 !== $response->getStatusCode()) {
                    continue;
                }

                $html     = $response->getBody()->getContents();
                $document = new Document($html);

                $goods = $document->find('*[data-qaid=product_block]');
                $goods = array_slice($goods, 0, 2);
                foreach ($goods as $good) {

                    $results[] = [
                        'link' => 'https://prom.ua' . $good->first('*[data-qaid=product_link]')->attr('href'),
                        'title' => $good->first('*[data-qaid=product_link]')->attr('title'),
                        'picture' => $good->first('*[data-qaid=image_link] img')->attr('src'),
                        'price' => $good->first('*[data-qaid=product_price]')->attr('data-qaprice'),

                    ];
                }
            }
            Log::debug('Prom parsed results: ' . json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            // аналіз варіантів подарунків з прому після першого запиту

            $prompt = PromptTemplate::create(template: 'Тобі наданий масив подарунків {results}. 
            Твоя задача серед {results}, обрати 8 унікальник товарів різних типів, які найкраще підходять імениннику. 
            Врахуй вік та стать іменинника.
            Вік та стать вирахуй, використовуючи дані імені {firstname}, прізвища {lastname}, та дати народження {date}
            У відповідь не включай схожі товари. 
            Не включати товари з аналогічними назвами. 
            Наприклад, я шукаю рюкзак туристичний, але не хочу, щоб серед результатів були "Рюкзак туристичний CATЕARA 28L" та "Рюкзак туристичний Crossroad 28L". 
            Враховуйте тільки унікальні назви товарів.
            Товари для дітей відкидай. Наприклад, "триколісний велосипед" не має бути серед результатів.
            Якщо не знаєш що відповісти, не відповідай нічого.')
                ->format([
                    '{firstname}' => $celebrant->firstname,
                    '{lastname}' => $celebrant->lastname,
                    '{date}' => $celebrant->birthday,
                    '{results}' => json_encode(Arr::pluck($results, 'title'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ])
                ->outputParser(new JsonPromParser());

            Log::debug('Prom parsed titles: ' . json_encode(Arr::pluck($results, 'title'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            $httpClient = new Client([
                'base_uri' => 'https://api.openai.com/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.chat_gpt'),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = $httpClient->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        SystemMessagePromptTemplate::fromString("
                    You are the manager of the company. You help choose a birthday gift for an colleague of your company.
                    Please follow the RESPONSE FORMAT INSTRUCTIONS when responding to the User.
                    "),
                        UserMessagePromptTemplate::fromString($prompt->toString()),
                    ],
                ],
            ]);

            $gifts_ids = Arr::get(json_decode($response->getBody(), true, $depth = 512, JSON_THROW_ON_ERROR), 'choices.0.message.content', []);
            Log::debug('ChatGPT unique ids: ' . json_encode($gifts_ids));

            if (empty($gifts_ids)) {
                return array_slice($results, 0, 5);
            } else {
                $unique_gifts = array_intersect_key($results, array_flip(json_decode($gifts_ids, true)));
                Log::debug('Prom unique options: ' . json_encode($unique_gifts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

                return array_values($unique_gifts);
            }

        } catch (\Throwable $exception) {
            dd($exception->getMessage() . $exception->getTraceAsString());
            return [];
        }
    }
}