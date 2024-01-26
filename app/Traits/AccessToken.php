<?php

namespace App\Traits;

use App\Models\UserData;
use Illuminate\Support\Facades\Http;

trait AccessToken {
    private function getAccessToken() {

    $userData = UserData::first();
    
    $grant_type = 'refresh_token';

    $response = Http::post('https://accounts.zoho.eu/oauth/v2/token?refresh_token='.
        $userData->refreshToken.'&client_id='.$userData->clientId.'&client_secret='.
        $userData->clientSecret.'&grant_type='.$grant_type
    );
    $response = json_decode($response)->access_token;
    return $response;
}
}