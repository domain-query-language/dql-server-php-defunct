<?php namespace Infrastructure\App\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\Compare;
use Infrastructure\App\Interpreter\Validator;

class Factory 
{    
    private $compare_factory;
    private $validator_factory;
    private $composite_factory;
    
    public function __construct(
        Compare\Factory $compare_factory, 
        Validator\Factory $validator_factory,
        Composite\Factory $composite_factory
    )
    {
        $this->compare_factory = $compare_factory;
        $this->validator_factory = $validator_factory;
        $this->composite_factory = $composite_factory;
    }
    
    public function ast($ast)
    {
        if (isset($ast->children)) {
           return $this->composite_factory->ast($ast->children, $this);
        }
        
        $condition = $ast->check->condition;
        if (isset($condition->comparator)) {
            return new Interpreter($this->compare_factory->ast($condition));
        } else {
            return new Interpreter($this->validator_factory->ast($condition));
        }
    } 
}

