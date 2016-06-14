<?php namespace App\Interpreter\Handler\Invariant;

use App\Interpreter\Validation\Validator;
use App\Interpreter\Query\Querier;

class Factory 
{     
    private $validator;
    private $querier;
    
    public function __construct(
        Validator $validator,
        Querier $querier)
    {
        $this->validator = $validator;
        $this->querier = $querier;
    }
    
    public function ast($ast)
    {
        return new Interpreter($this->querier, $this->validator, $ast);
    }
}



