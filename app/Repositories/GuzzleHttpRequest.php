<?php

namespace App\Repositories;

use GuzzleHttp\Client;
class GuzzleHttpRequest {
    protected $client;

	public function __construct()
	{

		$this->client = new Client([
                                    'base_uri' => env('API_URL'),
                                    'headers' => [
                                        // 'x-api-key' => config('app.cat_api'),
                                        'Content-Type'  => 'application/json'
                                    ]
                                ]);

	}

	/**
	 * Send Get Request using GuzzleHttp
	 *
	 * @param $url
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function get($url)
	{
            $response = $this->client->request('GET', trim($url));

        return json_decode($response->getBody()->getContents());
	}

}