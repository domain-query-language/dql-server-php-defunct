<?php namespace App\Interpreter\Check;

use App\Interpreter\Compare;
use App\Interpreter\Validator;

class Factory 
{    
    private $compare_factory;
    private $validator_factory;
    
    public function __construct(
        Compare\Factory $compare_factory, 
        Validator\Factory $validator_factory
    )
    {
        $this->compare_factory = $compare_factory;
        $this->validator_factory = $validator_factory;
    }
    
    public function ast($ast)
    {
        $condition = $ast->condition;
        $interpreters = [];
        foreach ($condition as $condition) {
            if (isset($condition->comparator)) {
                $interpreters[] = $this->compare_factory->ast($condition);
            } else {
                $interpreters[] = $this->validator_factory->ast($condition);
            }
        }
        return new Interpreter($interpreters);
    }
}



