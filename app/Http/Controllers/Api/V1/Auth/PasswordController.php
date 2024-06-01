<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function __invoke(PasswordRequest $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json(['message' => 'password updated'], Response::HTTP_ACCEPTED);
    }
}
