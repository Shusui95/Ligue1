<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class PresentationConversation extends Conversation{

	public function presentation(){
		$bot = $this->getBot();
		$user = $bot->getUser();
		$bot->reply("Hello ".$user->getFirstName()." o/\n
			I'm a chatbot. For interact with me, you have the persistent menu in the left bottom corner.\n
			I can give you the results of French League 1, teams & strikers rankings");
	}

	/**
	 * Start the conversations
	 */
	public function run(){
		$this->presentation();
	}
}