<?php namespace Infrastructure\App\Interpreter\ValueObject;

class Factory 
{    
    public function ast($ast)
    {
        $condition = $ast->validator->condition;
        return new Interpreter($condition->comparator, $condition->value->literal);
    }
}

