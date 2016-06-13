<?php namespace App\Interpreter\Invariant;

use App\Interpreter\Context;
use App\Interpreter\Validation\Validator;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $query;
    private $validator;
    private $ast;
        
    public function __construct($query, Validator $validator, $ast)
    {
        $this->query = $query;
        $this->validator = $validator;
        $this->ast = $ast;
    }
    
    public function interpret(Context $context)
    { 
        $context = $this->query->interpret($context);
        return $this->validator->check($this->ast->id, $context->data);
    }
}



