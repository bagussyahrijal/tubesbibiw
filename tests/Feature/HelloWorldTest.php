<?php

use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    public function testHelloWorldResponse()
    {
        $response = 'Hello World'; // Simulate the response from your application
        $this->assertEquals('Hello World', $response);
    }
}