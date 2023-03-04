<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\WeatherUpdate;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WeatherUpdateController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function update()
    {
        Log::info('Starting weather update');
        $users = User::all();

        foreach ($users as $user) {
            if (!is_numeric($user->latitude) || !is_numeric($user->longitude)) {
                continue;
            }

            $url = "https://api.weather.gov/points/{$user->latitude},{$user->longitude}";

            for ($i = 0; $i < 3; $i++) {
                try {
                    $response = $this->client->get($url);
                    $weather = json_decode($response->getBody()->getContents(), true);

                    $forecastUrl = $weather['properties']['forecast'];

                    $forecastResponse = $this->client->get($forecastUrl);
                    $forecast = json_decode($forecastResponse->getBody()->getContents(), true);

                    if ($forecast) {
                        WeatherUpdate::where('user_id', $user->id)->delete();
                        $weatherUpdate = new WeatherUpdate;
                        $weatherUpdate->user_id = $user->id;
                        $weatherUpdate->weather = $forecast;
                        $weatherUpdate->url = $forecastUrl;
                        $weatherUpdate->save();
                        Log::info('Successfully updated user', ['user_id' => $user->id]);
                        break;
                    } else {
                        Log::error('Empty forecast data', ['user_id' => $user->id]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error getting weather data', ['user_id' => $user->id, 'exception' => $e]);
                }

                if ($i < 2) {
                    sleep(1);
                }
            }
        }

        Log::info('Finishing weather update');
    }
}
