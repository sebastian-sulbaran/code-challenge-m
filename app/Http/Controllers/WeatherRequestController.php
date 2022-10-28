<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\WeatherStatus;
use App\Models\WeatherRequest;
use Illuminate\Support\Facades\Bus;

class WeatherRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $weather_requests = WeatherRequest::paginate(5);
        $response['data']['requests'] = $weather_requests;
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $response = []; 
        $request->validate([
            'city' => 'required|string'
        ]);
        
        $user = $request->user();

        $weather_request = new WeatherRequest;

        $weather_request->user_id = $user ? $user->id : null; 
        $weather_request->save();
        $transaction = WeatherStatus::dispatch($weather_request, $request->city); //implementar con batch
        dd($transaction);
        $response['data']['id'] = $weather_request->id;

        //$batch->finished();
        return response()->json($response,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Request $request, $id)
    {
        $weather_request = WeatherRequest::findOrFail($id); //apply trycatch blocks
        $response['data']['request'] = $weather_request; //use a resourse to map the object 
        return response()->json($response,200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $weather_request = WeatherRequest::findOrFail($id); //apply trycatch blocks
        $weather_request->delete();
        $response['data'] = ""; //use a resourse to map the object 
        return response()->json($response,204);
    }
}
