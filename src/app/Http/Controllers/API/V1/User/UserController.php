<?php

namespace App\Http\Controllers\API\V1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController {
  /**
   * find all users api
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse {
    $users = User::all();

    return $this->sendResponse($users, 'response all users');
  }

  /**
   * find user api
   *
   * @return \Illuminate\Http\Response
   */
  public function show($userId): JsonResponse {
    $user = User::find($userId);

    return $this->sendResponse($user, 'response user');
  } 
}