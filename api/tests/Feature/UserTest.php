<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    private $base_route;

    public function setUp() :void
    {
        parent::setUp();
        $this->base_route = 'api/users';
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserShouldPass()
    {
        $payload = [
            'name' => 'test' . now(),
            'password' => 'testing'
        ];

        $response =  $this->post($this->base_route, $payload)->decodeResponseJson();
        
        $this->assertEquals($payload['name'], $response['data']['name']);

        $this->assertEquals('0.0', $response['data']['balance']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserShouldFail()
    {
        $payload = [
            'name' => 'test',
            'password' => 'testing'
        ];

        $this->post($this->base_route, $payload)->decodeResponseJson();

        $payload = [
            'name' => 'test',
            'password' => 'testing'
        ];

        $response = $this->post($this->base_route, $payload)->decodeResponseJson();
        
        $this->assertEquals('Username is already been used, try another one.', $response['erro']);
    }
}
