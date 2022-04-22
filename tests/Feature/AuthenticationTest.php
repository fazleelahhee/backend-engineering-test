<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * to to is required field validation triggered.
     *
     * @return void
     */
    public function testRequiredFields()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    /**
     * To test invalid password length
     *
     * @return void
     */
    public function testInvalidPasswordLenght()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password must be at least 8 characters."]
                ]
            ]);
    }

    /**
     * To test invalid email address
     *
     * @return void
     */
    public function testInvalidEmailAddress()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doeexample.com",
            "password" => "demo1245"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."]
                ]
            ]);
    }

    /**
     * To test user successfully registered with app
     *
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John smith",
            "email" => "unique@example.com",
            "password" => "john12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                "access_token",
                "token_type"
            ]);
    }

    /**
     * to test user must enter email and password
     *
     * @return void
     */
    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

     /**
     * to test user can successfully login
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create();

        $loginData = ['email' => $user->email, 'password' => 'password'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
               "message",
                "access_token",
                "token_type"
            ]);

        $this->assertAuthenticated();
    }
}
