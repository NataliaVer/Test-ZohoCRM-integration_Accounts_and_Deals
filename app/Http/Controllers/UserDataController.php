<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;

class UserDataController extends Controller
{
    
    public function StoreUserData(Request $request) {

        $data = [
            'clientId' => $request->get('clientId'),
            'clientSecret' => $request->get('clientSecret'),
            'refreshToken' => $request->get('refreshToken')
        ];

        $UserData = UserData::create($data);

        return 'User data was created saccessfully';
    }
}
