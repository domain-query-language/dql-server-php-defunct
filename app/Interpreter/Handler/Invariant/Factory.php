<?php namespace App\Interpreter\Handler\Invariant;

use App\Interpreter\Validation\Validator;
use App\Interpreter\Query;
use App\Interpreter\NullInterpreter;

class Factory 
{     
    private $validator;
    private $query_factory;
    
    public function __construct(
        Validator $validator,
        Query\Factory $query_factory)
    {
        $this->validator = $validator;
        $this->query_factory = $query_factory;
    }
    
    public function ast($ast)
    {
        $query = new NullInterpreter();
        if ($ast->query) {
            $query = $this->query_factory->ast($ast);
        }
        return new Interpreter($query, $this->validator, $ast);
    }
}



