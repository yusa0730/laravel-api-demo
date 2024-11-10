<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LogoutController extends BaseController {
  /**
   * Logout api
   *
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request): JsonResponse {
    $request->user()->currentAccessToken()->delete();

    return $this->sendResponse(null, null, 200, 'successfully logout');
  }
}