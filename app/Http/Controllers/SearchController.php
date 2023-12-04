<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'Osaka');
        $countryCode = $request->input('country_code', 'JP');
        $category = $request->input('category', 'food');
        $limitResult = $request->input('limit_result', '5');
        $countries = Country::all();
        $foursquareResponse = Http::withHeaders([
            "Authorization" => config('services.foursquare.key'),
        ])->get(config('services.foursquare.url'), [
            'near' => "$city,$countryCode",
            'query' => "$category",
            'limit' => $limitResult
        ]);

        $openweathermapResponse = Http::get(config('services.openweather.url'), [
            'q' => "$city,$countryCode",
            'units' => 'metric',
            'appid' => config('services.openweather.key'),
        ]);

        $foursquareData = $foursquareResponse->json();
        $openweathermapData = $openweathermapResponse->json();

        return view(
            'search.index',
            compact(
                'foursquareData',
                'openweathermapData',
                'city',
                'countryCode',
                'category',
                'limitResult',
                'countries'
            )
        );
    }
}
