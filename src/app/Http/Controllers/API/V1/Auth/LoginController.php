<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseController {
  /**
   * Login api
   *
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request): JsonResponse {
    // ユーザーの認証情報（メールアドレスとパスワード）が正しいかを確認しています。
    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
      return $this->sendError('parameter error.', ['error' => 'parameter error'], 400);
    }

    $user = Auth::user();
    $data['token'] = $user->createToken('API Access')->plainTextToken;
    $data['userId'] = $user->id;

    return $this->sendResponse('data', $data, 200, 'User Login Successfully.');
  }
}