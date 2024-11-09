<?php

namespace App\Http\Controllers\API\V1\Todo;

use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class TodoController extends BaseController {
  /**
   * find all todos of user api
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse {}

  /**
   * find todo of user api
   *
   * @return \Illuminate\Http\Response
   */
  public function show(): JsonResponse {}

  /**
   * create todo of user api
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request, $userId): JsonResponse {
    $validator = Validator::make($request->all(), [
      'content' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $input = $request->all();
    $input['user_id'] = $userId;
    $input['complated'] = false;
    $todo = Todo::create($input);

    return $this->sendResponse($todo, 'User Todo successfully');
  }

  /**
   * update todo of user api
   *
   * @return \Illuminate\Http\Response
   */
  public function update(): JsonResponse {}

  /**
   * delete todo of user api
   *
   * @return \Illuminate\Http\Response
   */
  public function delete(): JsonResponse {}
}