<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  public function login(LoginRequest $request)
  {
    $user = User::firstWhere('email', $request->email);
    if (!Hash::check($request->password, $user->password)) {
      return response([
        'message' => "Password is incorrect"
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $token = $user->createToken('app_token')->plainTextToken;

    return response([
      'user' => $user,
      'token' => $token,
    ]);
  }
}
