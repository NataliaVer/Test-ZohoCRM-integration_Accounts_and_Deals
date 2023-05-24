<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Deal\StoreRequest;
use App\Http\Requests\Deal\UpdateRequest;

use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = $this->getAccessToken();
        //sort_by

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])->get('https://www.zohoapis.eu/crm/v2/Deals?sort_by=Stage&sort_order=asc');
        return $response;
    }

    private function getAccessToken()
    {
        //ці значення потрібно буде перемістити в базу данних
        $clientId = '1000.HZXPGRT1HWOLBUS6V5L8OSQ894NFIQ';
        $clientSecret = '4fcd7c79d6c1686d8a6007f7fffa3cf07568858c0f';
        $refreshToken = '1000.f85b722ef2a65eced2f87fbaa8185929.275104f52ee477f2f19dba19b000eea1';
        $grant_type = 'refresh_token';

        $response = Http::post('https://accounts.zoho.eu/oauth/v2/token?refresh_token='.
            $refreshToken.'&client_id='.$clientId.'&client_secret='.
            $clientSecret.'&grant_type='.$grant_type
        );
        $response = json_decode($response)->access_token;
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $data = $request->validated();

        $accessToken = $this->getAccessToken();

        $param = ['data' => [
            ['Deal_Name' => $data['Deal_Name'],
            'Stage' => $data['Stage'],
            'Account_Name' => [
                "id" => $data['Account']
                ]
            ],
        ]];

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->post('https://www.zohoapis.eu/crm/v2/Deals', $param);
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $accessToken = $this->getAccessToken();

        $param = ['data' => [
            ['Deal_Name' => $data['Deal_Name'],
            'Stage' => $data['Stage'],
            'Account_Name' => [
                "id" => $data['Account']
                ]
            ],
        ]];

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->put('https://www.zohoapis.eu/crm/v2/Deals/'.$id, $param);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->delete('https://www.zohoapis.eu/crm/v2/Deals/'.$id);
        
        return $response;
    }
}
