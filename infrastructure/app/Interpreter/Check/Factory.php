<?php namespace Infrastructure\App\Interpreter\Check;

use Infrastructure\App\Interpreter\Compare;
use Infrastructure\App\Interpreter\Validator;

class Factory 
{    
    private $compare_factory;
    private $validator_factory;
    
    public function __construct(
        Compare\Factory $compare_factory, 
        Validator\Factory $validator_factory)
    {
        $this->compare_factory = $compare_factory;
        $this->validator_factory = $validator_factory;
    }
    
    public function ast($ast)
    {
        $condition = $ast->condition;
        if (isset($condition->comparator)) {
            return $this->compare_factory->ast($condition);
        } else {
            return $this->validator_factory->ast($condition);
        }
    }
}



