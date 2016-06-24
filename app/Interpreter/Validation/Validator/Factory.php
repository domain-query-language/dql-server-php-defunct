<?php namespace App\Interpreter\Validation\Validator;

class Factory 
{    
    public function ast($ast)
    {   
        return new Interpreter($ast->value_left,  $ast->value_right);
    }
}

