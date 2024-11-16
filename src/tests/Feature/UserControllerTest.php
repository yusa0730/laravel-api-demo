<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserControllerTest extends TestCase
{
	use RefreshDatabase, WithFaker;

	public function test_user_response_200(): void
	{
		$user = User::factory()->create([
			'id' => 1,
			'name' => 'test',
			'email' => 'test@gmail.com'
		]);

		// トークンを生成（Sanctumの場合）
    $tokenAll = $user->createToken('TestToken')->plainTextToken;
		$token = Str::after($tokenAll, '|');

		Log::info('Generated Token: ' . $token);

    // Authorizationヘッダーを追加してリクエストを送信
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
    ])->getJson("/api/v1/users/{$user->id}");

		$response->assertStatus(200);
		$response->assertJson([
			'status' => 200,
			'user' => [
				'id' => $user->id,
				'email' => $user->email,
				'email_verified_at' => $user->email_verified_at->toISOString(),
				'created_at' => $user->created_at->toISOString(),
				'updated_at' => $user->updated_at->toISOString(),
			]
		]);
	}

	public function test_user_response_401_by_token_invalid(): void
	{
		$user = User::factory()->create([
			'id' => 1,
			'name' => 'test',
			'email' => 'test@gmail.com'
		]);

		$token = "test token";

		Log::info('Generated Token: ' . $token);

    // Authorizationヘッダーを追加してリクエストを送信
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
    ])->getJson("/api/v1/users/{$user->id}");

		$response->assertStatus(401);
		$response->assertJson([
			'error' => [
				'status' => 401,
				'message' => 'Unauthorized',
				'details' => [
					'accessToken' => ['Token not found in database']
				]
			]
		]);
	}

	public function test_user_response_401_by_without_token(): void
	{
		$user = User::factory()->create([
			'id' => 1,
			'name' => 'test',
			'email' => 'test@gmail.com'
		]);

    // Authorizationヘッダーを追加してリクエストを送信
    $response = $this->getJson("/api/v1/users/{$user->id}");

		$response->assertStatus(401);
		$response->assertJson([
			'error' => [
				'status' => 401,
				'message' => 'Unauthorized',
				'details' => [
					'accessToken' => ['Access token is required but not provided']
				]
			]
		]);
	}

	public function test_user_response_403(): void
	{
		$user = User::factory()->create([
			'id' => 1,
			'name' => 'test',
			'email' => 'test@gmail.com'
		]);

		// トークンを生成（Sanctumの場合）
    $tokenAll = $user->createToken('TestToken')->plainTextToken;
		$token = Str::after($tokenAll, '|');

		Log::info('Generated Token: ' . $token);

    // Authorizationヘッダーを追加してリクエストを送信
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
    ])->getJson("/api/v1/users/2");

		$response->assertStatus(403);
		$response->assertJson([
			'error' => [
				'status' => 403,
				'message' => 'Forbidden',
				'details' => [
					'userId' => ['This action is not authorized for the specified user']
				]
			]
		]);
	}
}
