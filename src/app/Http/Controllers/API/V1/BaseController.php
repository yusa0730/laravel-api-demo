<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller {
  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendResponse($keyName, $result, $code, $message = null) {
    $response = [
      'status' => $code
    ];

    if (isset($keyName) && isset($result)) {
      $response[$keyName] = $result;
    }

    if (isset($message)) {
      $response['message'] = $message;
    }

    return response()->json($response, $code);
  }

  /**
  * return error response.
  *
  * @return \Illuminate\Http\Response
  */
  public function sendError($error, $errorMessages = [], $code = 404) {
    $response = [
      'status' => $code,
      'message' => $error,
    ];

    if (!empty($errorMessages)) {
      $response['data'] = $errorMessages;
    }

    return response()->json($response, $code);
  }
}