<?php

class ComposerTest extends \PHPUnit_Framework_TestCase 
{    
    public function test_load_library()
    {
        $integer = new \EventSourced\ValueObject\ValueObject\Integer(1);
        $this->assertEquals(1, $integer->value());
    }
}


