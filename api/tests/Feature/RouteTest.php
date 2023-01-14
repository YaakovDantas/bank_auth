<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSimpleApiRouteShouldPass()
    {
        $response =  $this->get('api/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWrongRouteShouldFail()
    {
        $response =  $this->get('api/trail');

        $response->assertStatus(404);
    }
}
