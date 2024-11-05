<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Url;
use App\Models\UrlVisit;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url'
        ]);
        $user = $request->user();
        $longUrl = $request->long_url;


        //check if URL already exists
        $existingUrl = Url::where('long_url', $longUrl)->first();
        if ($existingUrl) {
            return response()->json(['short_url' => url("/v1/{$existingUrl->short_code}")], 200);
        }

        //generate short code
        $shortCode = Str::random(6);
        Url::create([
            'user_id' => $user->id,
            'long_url' => $longUrl,
            'short_code' => $shortCode
        ]);
        return response()->json(['short_url' => url("/v1/{$shortCode}")]);
    }

    public function redirect($shortCode)
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        return redirect($url->long_url);
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $urls = $user->urls()->get();

        $response = $urls->map(function ($url) {
            return [
                'short_code' => $url->short_code,
                'long_url' => $url->long_url,
            ];
        });

        return response()->json($response);
    }
}
