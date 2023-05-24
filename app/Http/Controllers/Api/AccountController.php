<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;

use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])->get('https://www.zohoapis.eu/crm/v2/Accounts');
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
            ['Account_Name' => $data['Account_name'],
            'Phone' => $data['Phone'],
            'Website' => $data['Website']
            ],
        ]];

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->post('https://www.zohoapis.eu/crm/v2/Accounts', $param);
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
            ['Account_Name' => $data['Account_Name'],
            'Phone' => $data['Phone'],
            'Website' => $data['Website']
            ],
        ]];

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->put('https://www.zohoapis.eu/crm/v2/Accounts/'.$id, $param);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = $this->getAccessToken();

        $relateds = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->get('https://www.zohoapis.eu/crm/v2/Accounts/'.$id.'/Deals');

        // return $relateds;

        $relateds = json_decode($relateds);

        $parametr = '';
        if ($relateds) {
            foreach($relateds->data as $related) {
                $parametr .= ($parametr!= ""?',':'')."$related->id";
            }
            
            $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
            ->delete('https://www.zohoapis.eu/crm/v2/Deals?ids='.$parametr);

            $answer = json_decode($response);

            if ($answer && $answer->data[0]->code == 'SUCCESS') {
                $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
                ->delete('https://www.zohoapis.eu/crm/v2/Accounts/'.$id);
            }

            //цей запит викликає помилку, підтримка Zoho сказали, що потрібно використовувати
            //звичайний запит на виделення записів, але треба буде передивитись без пов'язаних списків
            //$response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
            //->delete('https://www.zohoapis.eu/crm/v2/Accounts/'.$id.'/Deals?ids='.$parametr);

            return $response;
        }

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])
        ->delete('https://www.zohoapis.eu/crm/v2/Accounts/'.$id);

        
        return $response;
    }
}
