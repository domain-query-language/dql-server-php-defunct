<?php

class WebInterfaceTest extends TestCase
{        
    public function test_load_form()
    {
        $response = $this->call('GET', 'dql/form');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(strlen($response->getContent()) > 0);
    }
    
    public function test_make_valid_request()
    {
        $data = ['statement'=>"create environment 'testing';"];
        $response = $this->call('POST', 'dql/command', $data);
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function test_make_invalid_request()
    {
        $data = [];
        $headers = ['HTTP_X-Requested-With'=> 'XMLHttpRequest'];
        $response = $this->call('POST', 'dql/command', $data, [], [], $headers);
        
        $this->assertEquals(422, $response->getStatusCode());
    }
}


