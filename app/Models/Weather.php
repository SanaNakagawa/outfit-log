<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;


class Weather extends Model
{
    use HasFactory;

    protected $table = 'weathers';
    protected $fillable = ['date', 'photo_id', 'max_temperature', 'min_temperature'] ;

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public static function fetchAndShowWeatherData($prefecture)
    {
        $apiUrl = 'https://api.open-meteo.com/v1/forecast'; // APIのURL
        
        $today = now()->format('Y-m-d');
        $yesterday = now()->subDay()->format('Y-m-d');
        
        $latitude = $prefecture->prefecture->latitude; // 緯度
        $longitude = $prefecture->prefecture->longitude; // 経度

        
        //Apiから当日の気温データを取得
        $response = Http::get($apiUrl, [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'hourly' =>'temperature_2m',
            'daily' =>'temperature_2m_max,temperature_2m_min',
            //'timezone' =>'Asia%2FTokyo',
            'start_date' => $yesterday,
            'end_date' => $today,
        ]);

        if($response->successful()){
            $data = $response->json();

            return [
                'today' => [
                    'max_temperature' => $data['daily']['temperature_2m_max'][1], // 今日の最高気温
                    'min_temperature' => $data['daily']['temperature_2m_min'][1], // 今日の最低気温
                ],
                'yesterday' => [
                    'max_temperature' => $data['daily']['temperature_2m_max'][0], // 昨日の最高気温
                    'min_temperature' => $data['daily']['temperature_2m_min'][0], // 昨日の最低気温
                ]
            ];

        } else {
            dd('Error:', $response->status(), $response->body());
            throw new \Exception('Failed to fetch weather data');
        }
    }

    
    public static function fetchAndSaveWeatherData($photoId, $date, $prefecture)
    {
        
        $apiUrl = 'https://api.open-meteo.com/v1/forecast'; // APIのURL
        $formattedDate = Carbon::parse($date)->format('Y-m-d');
        $latitude = $prefecture->prefecture->latitude; // 緯度
        $longitude = $prefecture->prefecture->longitude; // 経度

        
        //Apiから気温データを取得
        $response = Http::get($apiUrl, [
            'latitude' => $latitude,
            'longitude' => $longitude,
            //'hourly' =>'temperature_2m',
            'daily' =>'temperature_2m_max,temperature_2m_min',
            //'timezone' =>'Asia%2FTokyo',
            'start_date' => $formattedDate,
            'end_date' => $formattedDate,
        ]);
       

        if($response->successful()){
            $data = $response->json();
            $maxTemperature = $data['daily']['temperature_2m_max'][0];
            $minTemperature = $data['daily']['temperature_2m_min'][0];

            // DBに保存            
            self::create([
                'date' => $date,
                'photo_id' => $photoId,
                'max_temperature' => $maxTemperature,
                'min_temperature' => $minTemperature,
            ]);

        } else {
            dd('Error:', $response->status(), $response->body());
            throw new \Exception('Failed to fetch weather data');
        }
    }
       
    
}
