<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Deal\StoreRequest;
use App\Http\Requests\Deal\UpdateRequest;

use App\Traits\AccessToken;

use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    use AccessToken;
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
