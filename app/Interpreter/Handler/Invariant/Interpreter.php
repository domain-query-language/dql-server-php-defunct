<?php namespace App\Interpreter\Handler\Invariant;

use App\Interpreter\Context;
use App\Interpreter\Validation\Validator;

class Interpreter
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
    
    public function interpret($root)
    { 
        $data = $this->query->interpret($root);
        return $this->validator->check($this->ast->id, $data);
    }
}



