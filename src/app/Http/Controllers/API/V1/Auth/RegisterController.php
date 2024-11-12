<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Exceptions\CustomException;

class RegisterController extends BaseController {
  /**
   * Register api
   *
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request): JsonResponse {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'confirmPassword' => 'required|same:password'
    ]);

    if ($validator->fails()) {
      throw new CustomException('Validation Error', $validator->errors(), 400);
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $data['token'] = $user->createToken('API Access')->plainTextToken;
    $data['userId'] = $user->id;

    return $this->sendResponse('data', $data, 201, 'User Registeration successfully');
  }
}