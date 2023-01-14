<?php

namespace Tests\Feature;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $base_route;
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->base_route = 'api/auth';

        $this->user = app(UserRepository::class)->create([
            'name' => Hash::make('test'),
            'password' => '1111',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginShouldPass()
    {
        $payload = [
            'name' => $this->user->name,
            'password' => '1111'
        ];
        $response =  $this->post($this->base_route . '/login', $payload);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserDataShouldPass()
    {
        $payload = [
            'name' => $this->user->name,
            'password' => '1111'
        ];
        $response =  $this->post($this->base_route . '/login', $payload)->decodeResponseJson();

        $token = $response['access_token'];

        $response = $this->json('GET', $this->base_route . '/user', [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $this->assertEquals($this->user->name, $response['data']['name']);
        $this->assertEquals($this->user->account->balance, $response['data']['balance']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserDataShouldFail()
    {
        $payload = [
            'name' => $this->user->name,
            'password' => '1111'
        ];
        $response =  $this->post($this->base_route . '/login', $payload)->decodeResponseJson();

        $token = $response['access_token'];

        $response = $this->json('GET', $this->base_route . '/user', [], ['Authorization' => "Bearer $token +1"])->decodeResponseJson();
        
        $this->assertEquals("user not found from token $token +1", $response['message']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginShouldFail()
    {
        $_ENV['APP_ENV'] = 'local'; 
        $payload = [
            'name' => $this->user->name,
            'password' => '11112'
        ];
        $response =  $this->post($this->base_route . '/login', $payload)->decodeResponseJson();
        
        $this->assertEquals($response['status'], 422);
        $this->assertEquals($response['msg'], 'fail.login');
        $this->assertFalse($response['success']);
        $_ENV['APP_ENV'] = 'testing'; 
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogoutShouldPass()
    {
        $payload = [
            'name' => $this->user->name,
            'password' => '1111'
        ];
        $response =  $this->post($this->base_route . '/login', $payload)->decodeResponseJson();

        $token = $response['access_token'];

        $response = $this->json('POST', $this->base_route . '/logout', [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $this->assertEquals($token, $response['revoked_token']);
    }
}
