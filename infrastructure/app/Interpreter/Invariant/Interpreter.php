<?php namespace Infrastructure\App\Interpreter\Invariant;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $result;
    
    public function __construct($result)
    {
        $this->result = $result;
    }
    
    public function interpret(Context $context)
    { 
        return $this->result;
    }
}



