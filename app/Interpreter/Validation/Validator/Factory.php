<?php namespace App\Interpreter\Validation\Validator;

class Factory 
{    
    public function ast($ast)
    {   
        return new Interpreter($ast->value_right->validator, $ast->value_right->arguments);
    }
}

