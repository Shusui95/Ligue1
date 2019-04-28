<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
	/**
	 *
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getUserInfo()
	{
		$facebookClient = new Client();
		$result = $facebookClient->request('GET',
			'https://graph.facebook.com/v3.2/me?access_token=EAAGLFIqUnZBABALt16TSGHOs1FooddcWHKhjW0uwdemFE3PCpJmbiwsB0yctfJfVpUwNhjw1Lk0V0YsdTZCV1OqdfiIb0THwCgu0LVxifPdfCrUctVSDZCdXj1ZCNjppRPbsVf5PVkeVO1kR8B5tjdxajhZA2Ik8XlQE86RH2l8GbPEc6i9CkrgK5B0jsfEoFFtZAo4QrlnLd9a0sl9ZAYE'
			);
//		$resultBody = json_decode($result->getBody());
//		echo $resultBody;
	}
}
