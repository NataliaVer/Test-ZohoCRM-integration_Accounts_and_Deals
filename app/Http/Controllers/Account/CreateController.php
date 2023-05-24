<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRequest;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(AccountRequest $request)
    {
        $data = $request->validated();
        return $data;
    }
}
