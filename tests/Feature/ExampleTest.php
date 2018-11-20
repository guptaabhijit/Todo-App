<?php

namespace Tests\Feature;

use Tests\TestCase;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


    private $client;

    public function setUp()
    {
        //default IP for vagrant/homestead  192.168.10.10
        //Use localhost if not running any virtual machine.
        $this->client = new Client([
            'base_uri'        => '192.168.10.10',
            'exceptions' => false,
        ]);

        parent::setUp();
    }



    public function testBasicTest()
    {
        $response = $this->client->request(
                'GET',
                '192.168.10.10/todos'
        );


        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testBasicErrorTest(){

        $response = "";
        try {

            $response = $this->client->request(
                'GET',
                '192.168.10.10'
            );
        }catch(ClientException $e){
            echo 'Uh oh! ' . $e->getMessage();
        }

        $this->assertEquals(400,$response->getStatusCode());
    }



    public function tearDown(){
        $this->client = null;
    }
}
