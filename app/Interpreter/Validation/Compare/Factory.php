<?php namespace App\Interpreter\Validation\Compare;

class Factory 
{    
    public function ast($ast)
    {
        return new Interpreter($ast->value_left, $ast->comparator, $ast->value_right);
    }
}

