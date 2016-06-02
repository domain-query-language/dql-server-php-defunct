<?php namespace App\Interpreter\Compare;

class Factory 
{    
    public function ast($ast)
    {
        return new Interpreter($ast->field, $ast->comparator, $ast->value->literal);
    }
}

