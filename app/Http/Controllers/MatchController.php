<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;

class MatchController extends Controller
{
    //
	public $footballServiceProvider;
	public $footballClient;
	public $apiKey;
	public $frenchLeagueId;

	public function __construct()
	{
		$this->apiKey = env("FOOTBALL_API_KEY");
		$headers= [
			'X-Auth-Token' => $this->apiKey
		];

		$this->footballClient = new Client(['headers' => $headers]);

		$this->frenchLeagueId = 2015;
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getLastMatchday(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId)->getBody()->getContents(), true);
		$currentMatchday = $result['currentSeason']['currentMatchday'];

		$matches = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId."/matches?matchday=".$currentMatchday)->getBody()->getContents(), true);
		info('last match', [$matches['matches']]);

		$matchesElements = [];

		foreach ($matches['matches'] as $match){
			$date = new \DateTime($match['utcDate']);
			$date = $date->format('l jS \of F Y H:i');
			if($match['status'] == 'FINISHED'){
				$subtitle = $date."\n"
					."half time : ".$match['score']['halfTime']['homeTeam']." - ".$match['score']['halfTime']['awayTeam']."\n"
					."full time : ".$match['score']['fullTime']['homeTeam']." - ".$match['score']['fullTime']['awayTeam']."\n"
					."referee : ".$match['referees'][0]['name'];
			}else{
				$subtitle = $date."\n";
			}
			array_push($matchesElements, Element::create($match['homeTeam']['name'].' - '.$match['awayTeam']['name'])
				->subtitle($subtitle)
				//->image('http://botman.io/img/botman-body.png')
//				->addButton(ElementButton::create('detail')
//					->payload('detail')
//					->type('postback'))
				);
		}

		$bot->reply(GenericTemplate::create()
			->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
			->addElements($matchesElements)
		);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getNextMatchday(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId)->getBody()->getContents(), true);
		$currentMatchday = $result['currentSeason']['currentMatchday'];

		$matches = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId."/matches?matchday=".($currentMatchday+1))->getBody()->getContents(), true);
		info('next match', [$matches['matches']]);

		$matchesElements = [];

		foreach ($matches['matches'] as $match){
			$date = new \DateTime($match['utcDate']);
			$date = $date->format('l jS \of F Y H:i');
			$subtitle = $date."\n";
			array_push($matchesElements, Element::create($match['homeTeam']['name'].' - '.$match['awayTeam']['name'])
				->subtitle($subtitle)
				);
		}

		$bot->reply(GenericTemplate::create()
			->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
			->addElements($matchesElements)
		);
	}
}
