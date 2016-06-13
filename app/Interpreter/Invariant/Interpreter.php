<?php namespace App\Interpreter\Invariant;

use App\Interpreter\Context;
use App\Interpreter\Validation\Validator;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $query;
    private $validator;
    private $as;
        
    public function __construct($query, Validator $validator, $ast)
    {
        $this->query = $query;
        $this->validator = $validator;
    }
    
    public function interpret(Context $context)
    { 
        $context = $this->query->interpret($context);
        dd($context);
        $this->validator->check();
        return $this->check->interpret($context);
    }
}



