<?php

namespace App\Traits;

use GuzzleHttp\Client;
trait ConnectionTrait {
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
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            throw $e;
        }
        return json_decode($response->getBody()->getContents());
	}

    // public function post($url, $data = array())
    // {
    //     try {
    //         if ($this->session->has(SessionKeys::AuthToken)) {
    //             $result = $this->Client->post($url, [
    //                 RequestOptions::JSON => $data,
    //                 'headers' => $this->setBearerHeader()
    //             ]);
    //         } else {
    //             $result = $this->Client->post($url, [RequestOptions::JSON => $data]);
    //         }
    //     } catch (\Exception $e) {
    //         throw $e;
    //     }
    //     return json_decode($result->getBody());
    // }


}