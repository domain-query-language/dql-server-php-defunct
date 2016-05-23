<?php namespace Infrastructure\App\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\Compare;
use Infrastructure\App\Interpreter\Validator;
use App\Interpreter\ValueObjectRepository;

class Factory 
{    
    private $compare_factory;
    private $validator_factory;
    private $value_object_repo;
    
    public function __construct(
        Compare\Factory $compare_factory, 
        Validator\Factory $validator_factory,
        ValueObjectRepository $value_object_repo
    )
    {
        $this->compare_factory = $compare_factory;
        $this->validator_factory = $validator_factory;
        $this->value_object_repo = $value_object_repo;
    }
    
    public function ast($ast)
    {
        if (isset($ast->children)) {
           return $this->composite_valueobject_factory($ast->children);
        }
        $condition = $ast->check->condition;
        if (isset($condition->comparator)) {
            return $this->compare_factory->ast($condition);
        } else {
            return $this->validator_factory->ast($condition);
        }
    } 
    
    private function composite_valueobject_factory($children_ast)
    {
        $interpreters = [];
        foreach ($children_ast as $vo_id) {
            $ast = $this->value_object_repo->fetch_ast($vo_id);
            $interpreters[] = $this->ast($ast);
        }
        
        return new CompositeInterpreter($interpreters, array_keys((array)$children_ast));
    }
}

