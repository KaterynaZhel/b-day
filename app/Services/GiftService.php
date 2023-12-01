<?php

namespace App\Services;

use App\Models\Celebrant;
use App\OutputParser\JsonListParser;
use App\Prompts\Chat\SystemMessagePromptTemplate;
use App\Prompts\Chat\UserMessagePromptTemplate;
use App\Prompts\PromptTemplate;
use DiDom\Document;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use JsonException;



class GiftService
{
    public function generateGifts(Celebrant $celebrant)
    {
        $hobbies = collect($celebrant->hobbies()->pluck('name'))->implode(',');

        $prompt = PromptTemplate::create(template: 'Які ідеї подарунків для співробітника по імені {firstname}, який народився {date}, 
        та працює в компанії {company} на посаді {position}. Має такі хобі як {hobbies}.')
            ->format([
                '{firstname}' => $celebrant->firstname,
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
            $client   = new Client();

            foreach ($gifts_AI as $gift) {

                $request  = new Request('GET', 'https://prom.ua/ua/search');
                $response = $client->send($request, [
                    'query' => [
                        'search_term' => $gift,
                        'price_local__lte' => $celebrant->gift_budget,
                    ]
                ]);

                $html = $response->getBody()->getContents();

                $document = new Document($html);

                $goods = $document->find('*[data-qaid=product_block]');
                $goods = array_slice($goods, 0, 5);

                foreach ($goods as $good) {

                    $results[] = [
                        'link' => 'https://prom.ua' . $good->first('*[data-qaid=product_link]')->attr('href'),
                        'title' => $good->first('*[data-qaid=product_link]')->attr('title'),
                        'picture' => $good->first('*[data-qaid=image_link] img')->attr('src'),
                        'price' => $good->first('*[data-qaid=product_price]')->attr('data-qaprice'),

                    ];
                }

            }
            return $results;


        } catch (\Throwable $exception) {
            $exception->getMessage();
            return [];
        }
    }
}