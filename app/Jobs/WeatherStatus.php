<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use App\Repositories\GuzzleHttpRequest;
use App\Models\WeatherRequest;
use Illuminate\Support\Facades\Http;

class WeatherStatus implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $url;
    private $weather_request;

    private $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WeatherRequest $weather_request, $url)
    {
        $this->weather_request = $weather_request;
        // $this->url = $weather_request->city;
        $this->url = $url;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->weather_request->response = json_encode(["bla" => "bla"]);
        $this->weather_request->response = $response = (Http::get(env('API_URL'),[ "city" => $this->url]))->getBody()->getContents();
        $response = json_decode($response)[0];
        $this->weather_request->region_name = $response->region_name;
        $this->weather_request->conditions = json_encode($response->current_conditions); 
        $this->weather_request->update();
    }
}
