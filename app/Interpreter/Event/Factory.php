<?php namespace App\Interpreter\Event;

use App\Interpreter\Validation;

class Factory
{    
    private $validator;
    
    public function __construct(Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
    
    public function ast($ast)
    {
        return new Interpreter($ast->id, $ast->aggregate_id, $this->validator);
    }
}

