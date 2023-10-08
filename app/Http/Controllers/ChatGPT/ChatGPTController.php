<?php

namespace App\Http\Controllers\ChatGPT;

use App\Http\Controllers\Controller;
use App\Models\Celebrant;
use App\OutputParser\JsonListParser;
use App\Prompts\Chat\SystemMessagePromptTemplate;
use App\Prompts\Chat\UserMessagePromptTemplate;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Prompts\PromptTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatGPTController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.chat_gpt'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function askToChatGpt(string $id)
    {

        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);

        $hobbiesArray = DB::table('hobby_celebrant')
            ->where('celebrant_id', '=', $celebrant->id)
            ->join('hobbies', 'hobbies.id', '=', 'hobby_celebrant.hobby_id')
            ->pluck('name');
        $hobbiesString = collect($hobbiesArray)->implode(',');

        $prompt = PromptTemplate::create(template: 'Які ідеї подарунків для співробітника по імені {firstname}, який народився {date}, 
        та працює в компанії {company} на посаді {position}. Має такі хобі як {hobbies}.')
            ->format([
                '{firstname}' => $celebrant->firstname,
                '{date}' => $celebrant->birthday,
                '{company}' => $celebrant->company->name,
                '{position}' => $celebrant->position,
                '{hobbies}' => $hobbiesString,
            ])
            ->outputParser(new JsonListParser());

        $response = $this->httpClient->post('chat/completions', [
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

        return json_decode($response->getBody(), true)['choices'][0]['message']['content'];
    }
}
