<?php

use App\Conversations\PresentationConversation;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\RankingControler;
use App\Providers;

$botman = resolve('botman');

$botman->hears('get_started|help', function ($bot) {
	$bot->startConversation(new PresentationConversation());
});
$botman->hears('last_day_results', MatchController::class.'@getLastMatchday');
$botman->hears('next_day_games', MatchController::class.'@getNextMatchday');
$botman->hears('strikers_ranking', RankingControler::class.'@getStrikersRanking');

$botman->hears('ask_basic_team_ranking', RankingControler::class.'@getAskBasicTeamsRanking');
$botman->hears('first_basic_team_ranking', RankingControler::class.'@getFirstBasicTeamsRanking');
$botman->hears('last_basic_team_ranking', RankingControler::class.'@getLastBasicTeamsRanking');

$botman->hears('ask_home_team_ranking', RankingControler::class.'@getAskHomeTeamsRanking');
$botman->hears('first_home_team_ranking', RankingControler::class.'@getFirstHomeTeamsRanking');
$botman->hears('last_home_team_ranking', RankingControler::class.'@getLastHomeTeamsRanking');

$botman->hears('ask_away_team_ranking', RankingControler::class.'@getAskAwayTeamsRanking');
$botman->hears('first_away_team_ranking', RankingControler::class.'@getFirstAwayTeamsRanking');
$botman->hears('last_away_team_ranking', RankingControler::class.'@getLastAwayTeamsRanking');
