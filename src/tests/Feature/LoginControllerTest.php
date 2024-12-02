<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_response_200()
	{
		$requestBody = [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'confirmPassword' => 'password',
		];
		$response = $this->postJson('/api/v1/auth/register', $requestBody);

        $loginRequestBody = [
            'email' => 'test@gmail.com',
            'password' => 'password'
		];
		$loginResponse = $this->postJson('/api/v1/auth/login', $loginRequestBody);

		$loginResponse->assertStatus(200);

		$loginResponse->assertJson([
			'status' => 200,
			'data' => [
				'userId' => 1,
				'accessToken' => true,
			],
			'message' => 'User Login Successfully'
		]);
	}
}
