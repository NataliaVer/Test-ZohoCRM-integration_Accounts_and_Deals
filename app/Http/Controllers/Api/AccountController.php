<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;

use App\Traits\AccessToken;
use App\Models\UserData;

use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    use AccessToken;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$accessToken])->get('https://www.zohoapis.eu/crm/v2/Accounts');
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
