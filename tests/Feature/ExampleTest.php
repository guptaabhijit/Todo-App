<?php

namespace Tests\Feature;

use Tests\TestCase;
use Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


   // private $client;

 /*   public function setUp()
    {
        //default IP for vagrant/homestead  192.168.10.10
        //Use localhost if not running any virtual machine.
       $this->client = new Client([
            'base_uri'        => '192.168.10.10',
            'exceptions' => false,
        ]);

        parent::setUp();
    }
*/


    public function testBasicTest()
    {
        Log::info("Inside testBasicTest");
        $response = $this->json('GET', '/todos');
        $response->assertStatus(404);
    }

    public function testBasicErrorTest(){

        $response = $this->json('GET', '/');
        $response->assertStatus(400);
    }



  /*  public function tearDown(){
        $this->client = null;
    }*/
}
