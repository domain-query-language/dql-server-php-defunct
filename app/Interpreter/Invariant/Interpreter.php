<?php namespace App\Interpreter\Invariant;

use App\Interpreter\Context;
use App\Interpreter\Check;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $query;
    private $check;
        
    public function __construct($query, Check\Interpreter $check)
    {
        $this->query = $query;
        $this->check = $check;
    }
    
    public function interpret(Context $context)
    { 
        $context = $this->query->interpret($context);
        return $this->check->interpret($context);
    }
}



