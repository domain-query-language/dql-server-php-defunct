<?php namespace App\Interpreter\Handler\Invariant;

use App\Interpreter\Validation\Validator;
use App\Interpreter\Query\Querier;

class Interpreter
{    
    private $querier;
    private $validator;
    private $ast;
        
    public function __construct(Querier $querier, Validator $validator, $ast)
    {
        $this->querier = $querier;
        $this->validator = $validator;
        $this->ast = $ast;
    }
    
    public function interpret($root)
    { 
        $data = $this->querier->query($this->ast->id, $root);
        return $this->validator->check($this->ast->id, $data);
    }
}



