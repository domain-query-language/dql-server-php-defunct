<?php namespace Infrastructure\App\Interpreter\Validator;

class Factory 
{    
    public function ast($ast)
    {        
        return new Interpreter($ast->validator, $ast->values);
    }
}

