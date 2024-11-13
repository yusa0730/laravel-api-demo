<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
	use RefreshDatabase, WithFaker;
	/**
	 * A basic feature test example.
	 */
	public function test_register_new_user()
	{
		$requestBody = [
				'name' => 'Test User',
				'email' => 'test@gmail.com',
				'password' => 'password',
				'confirmPassword' => 'password',
		];
		$response = $this->postJson('/api/v1/auth/register', $requestBody);

		$response->assertStatus(201);

		$response->assertJson([
			'status' => 201,
			'data' => [
				'userId' => 1,
				'accessToken' => true,
			],
			'message' => 'User Registeration successfully'
		]);

		// データベースにユーザーが登録されていることを確認
		$this->assertDatabaseHas('users', [
			'email' => $requestBody['email'],
		]);
	}

	public function test_400_error_when_email_is_invalid()
	{
		$requestBody = [
				'name' => $this->faker->name,
				'email' => 'testtest',
				'password' => 'password',
				'confirmPassword' => 'password',
		];

		$response = $this->postJson('/api/v1/auth/register', $requestBody);

		$response->assertStatus(400);

		$response->assertJson([
			'error' => [
				'status' => 400,
				'message' => 'Validation Error',
				'details' => [
					'email' => ['The email field must be a valid email address.']
				]
			]
		]);
	}

	public function test_400_error_when_confirmPassword_is_invalid()
	{
		$requestBody = [
				'name' => $this->faker->name,
				'email' => 'test@gmail.com',
				'password' => 'password',
				'confirmPassword' => 'password1',
		];

		$response = $this->postJson('/api/v1/auth/register', $requestBody);

		$response->assertStatus(400);

		$response->assertJson([
			'error' => [
				'status' => 400,
				'message' => 'Validation Error',
				'details' => [
					'confirmPassword' => ['The confirm password field must match password.']
				]
			]
		]);
	}

	public function test_400_error_when_user_is_duplicated()
	{
		$userData = [
			'name' => $this->faker->name,
			'email' => 'test@gmail.com',
			'password' => bcrypt('password'),
		];
		User::create($userData);

		$requestBody = [
				'name' => $this->faker->name,
				'email' => 'test@gmail.com',
				'password' => 'password',
				'confirmPassword' => 'password',
		];

		$response = $this->postJson('/api/v1/auth/register', $requestBody);

		$response->assertStatus(400);

		$response->assertJson([
			'error' => [
				'status' => 400,
				'message' => 'Request Parameter Error',
				'details' => [
					'email' => ['The email address already exists']
				]
			]
		]);
	}
}
