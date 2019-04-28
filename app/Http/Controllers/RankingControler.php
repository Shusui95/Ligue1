<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use BotMan\Drivers\Facebook\Extensions\ElementButton;

class RankingControler extends Controller
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
	public function getStrikersRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/scorers')->getBody()->getContents(), true);

		info('striker ranking', [$result]);

		$scorersElement = [];

		for ($i = 0; $i < 4; $i++){
			$datetime = date_diff(date_create(), date_create($result['scorers'][$i]['player']['dateOfBirth']));
			$age      = $datetime->format('%Y');
			$subtitle = $age." years old\n"
				.$result['scorers'][$i]['team']['name']."\n"
				.$result['scorers'][$i]['numberOfGoals']." goals\n";
			array_push($scorersElement, Element::create(($i+1).' - '.$result['scorers'][$i]['player']['name'])
				->subtitle($subtitle)
			);
		}

		$bot->reply(ListTemplate::create()
			->useCompactView()
			->addElements($scorersElement)
		);
	}

	/**
	 * @param BotMan $bot
	 * @param $result
	 */
	public function replyGenericTemplate(Botman $bot, $result, $start){

		$teamsElement = [];
		for($i = $start; $i < $start + 10; $i++){
			$image = substr($result['standings'][0]['table'][$i]['team']['crestUrl'], 0, -3).'png';

			array_push($teamsElement, Element::create(($i+1).' - '.$result['standings'][0]['table'][$i]['team']['name'])
				->subtitle($result['standings'][0]['table'][$i]['playedGames']." played games\n"
					.$result['standings'][0]['table'][$i]['points'].' points ('
					.$result['standings'][0]['table'][$i]['won'].'W '
					.$result['standings'][0]['table'][$i]['draw'].'D '
					.$result['standings'][0]['table'][$i]['lost']."L)\n"
					.$result['standings'][0]['table'][$i]['goalDifference'].' goal difference')
				->image($image)
			);
		}

		$bot->reply(GenericTemplate::create()
			->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
			->addElements($teamsElement)
		);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAskBasicTeamsRanking(Botman $bot){
		$bot->reply(ButtonTemplate::create('Which part of basic ranking do you want ?')
			->addButton(ElementButton::create('First part')
				->type('postback')
				->payload('first_basic_team_ranking')
			)
			->addButton(ElementButton::create('Last part')
				->type('postback')
				->payload('last_basic_team_ranking')
			)
		);
	}
	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAskHomeTeamsRanking(Botman $bot){
		$bot->reply(ButtonTemplate::create('Which part of home ranking do you want ?')
			->addButton(ElementButton::create('First part')
				->type('postback')
				->payload('first_home_team_ranking')
			)
			->addButton(ElementButton::create('Last part')
				->type('postback')
				->payload('last_home_team_ranking')
			)
		);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAskAwayTeamsRanking(Botman $bot){
		$bot->reply(ButtonTemplate::create('Which part of away ranking do you want ?')
			->addButton(ElementButton::create('First part')
				->type('postback')
				->payload('first_away_team_ranking')
			)
			->addButton(ElementButton::create('Last part')
				->type('postback')
				->payload('last_away_team_ranking')
			)
		);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getFirstBasicTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=TOTAL')->getBody()->getContents(), true);
		info('team ranking', [$result]);
		$this->replyGenericTemplate($bot, $result, 0);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getLastBasicTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=TOTAL')->getBody()->getContents(), true);
		info('team ranking', [$result]);
		$this->replyGenericTemplate($bot, $result, 10);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getFirstHomeTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=HOME')->getBody()->getContents(), true);
		info('team ranking', [$result]);
		$this->replyGenericTemplate($bot, $result, 0);
	}
	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getLastHomeTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=HOME')->getBody()->getContents(), true);
		info('team ranking', [$result]);
		$this->replyGenericTemplate($bot, $result, 10);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getFirstAwayTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=AWAY')->getBody()->getContents(), true);

		info('team ranking', [$result]);

		$this->replyGenericTemplate($bot, $result, 0);
	}

	/**
	 * @param BotMan $bot
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getLastAwayTeamsRanking(Botman $bot){
		$result = json_decode($this->footballClient->request('GET', "https://api.football-data.org/v2/competitions/".$this->frenchLeagueId.'/standings?standingType=AWAY')->getBody()->getContents(), true);

		info('team ranking', [$result]);

		$this->replyGenericTemplate($bot, $result, 10);
	}
}
