<?php namespace App\Interpreter\Validation\Validator;

class Factory 
{    
    public function ast($ast)
    {        
        return new Interpreter($ast->validator, $ast->values);
    }
}

