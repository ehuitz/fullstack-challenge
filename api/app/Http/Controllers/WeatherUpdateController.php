<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\WeatherUpdate;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeatherUpdateController extends Controller
{
    public function update()
    {

        Log::info('starting weather update');


        $client = new Client();
        $users = User::all();

        foreach ($users as $user) {
            $url="https://api.weather.gov/points/{$user->latitude},{$user->longitude}";
            try{
                 $response = $client->get($url);
                 $weather = json_decode($response->getBody()->getContents(), true);
                }
            catch (\Exception $e) {
                 $weather = null; // Store empty data if a 404 error occurs
            }

            $weatherUpdate = new WeatherUpdate;
            $weatherUpdate->user_id = $user->id;
            $weatherUpdate->weather = json_encode($weather);
            $weatherUpdate->url = ($url);


            $weatherUpdate->save();
        }
            Log::info('finishing weather update');
        }



   }

