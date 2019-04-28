<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Facebook Token
    |--------------------------------------------------------------------------
    |
    | Your Facebook application you received after creating
    | the messenger page / application on Facebook.
    |
    */
    'token' => env('FACEBOOK_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Facebook App Secret
    |--------------------------------------------------------------------------
    |
    | Your Facebook application secret, which is used to verify
    | incoming requests from Facebook.
    |
    */
    'app_secret' => env('FACEBOOK_APP_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Facebook Verification
    |--------------------------------------------------------------------------
    |
    | Your Facebook verification token, used to validate the webhooks.
    |
    */
    'verification' => env('FACEBOOK_VERIFICATION'),

    /*
    |--------------------------------------------------------------------------
    | Facebook Start Button Payload
    |--------------------------------------------------------------------------
    |
    | The payload which is sent when the Get Started Button is clicked.
    |
    */
    'start_button_payload' => 'GET_STARTED',

    /*
    |--------------------------------------------------------------------------
    | Facebook Greeting Text
    |--------------------------------------------------------------------------
    |
    | Your Facebook Greeting Text which will be shown on your message start screen.
    |
    */
    'greeting_text' => [
        'greeting' => [
            [
                'locale' => 'default',
                'text' => 'Hello!',
            ],
            [
                'locale' => 'en_US',
                'text' => 'Informations on French League 1',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Persistent Menu
    |--------------------------------------------------------------------------
    |
    | Example items for your persistent Facebook menu.
    | See https://developers.facebook.com/docs/messenger-platform/reference/messenger-profile-api/persistent-menu/#example
    |
    */
    'persistent_menu' => [
        [
            'locale' => 'default',
            'composer_input_disabled' => 'true',
            'call_to_actions' => [
                [
                    'title' => 'Games / Results',
                    'type' => 'nested',
                    'call_to_actions' => [
                        [
                            'title' => 'Last day results',
                            'type' => 'postback',
                            'payload' => 'last_day_results',
                        ],
	                    [
                            'title' => 'Next day games',
                            'type' => 'postback',
                            'payload' => 'next_day_games',
                        ],
//	                    [
//                            'title' => 'Specific day',
//                            'type' => 'postback',
//                            'payload' => 'specific_day',
//                        ],
                    ],
                ],
                [
                    'type' => 'nested',
                    'title' => 'Ranking',
	                'call_to_actions' => [
		                [
			                'title' => 'Teams ranking',
			                'type' => 'nested',
			                'call_to_actions' => [
				                [
					                'title' => 'Basic ranking',
					                'type' => 'postback',
					                'payload' => 'ask_basic_team_ranking',
				                ],
				                [
					                'title' => 'Home teams ranking',
					                'type' => 'postback',
					                'payload' => 'ask_home_team_ranking',
				                ],
				                [
					                'title' => 'Away teams ranking',
					                'type' => 'postback',
					                'payload' => 'ask_away_team_ranking',
				                ],
			                ],
		                ],
		                [
			                'title' => 'Strikers ranking',
			                'type' => 'postback',
			                'payload' => 'strikers_ranking',
		                ],
	                ],
                ],
	            [
		            'title' => 'Help',
		            'type' => 'postback',
		            'payload' => 'help',
	            ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Domain Whitelist
    |--------------------------------------------------------------------------
    |
    | In order to use domains you need to whitelist them
    |
    */
    'whitelisted_domains' => [
        'https://petersfancyapparel.com',
    ],
];
