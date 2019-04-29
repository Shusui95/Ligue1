<?php

namespace Tests\BotMan;

use Illuminate\Foundation\Inspiring;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHelpOrPresentation()
    {
        $this->bot
            ->receives('help')
            ->assertReply("Hello Marcel o/\nI'm a chatbot. For interact with me, you have the persistent menu in the left bottom corner.\nI can give you the results of French League 1, teams & strikers rankings");
    }
}
