<?php namespace Infrastructure\App\Interpreter\Entity;

use Infrastructure\App\Interpreter\ValueObject;

class Factory 
{    
    private $value_object_factory;
    
    public function __construct(ValueObject\Factory $vo_factory)
    {
        $this->value_object_factory = $vo_factory;
    }
    
    public function ast($ast)
    {
        if (!isset($ast->children->id)) {
            throw new Exception("Entities must have an ID");
        }
        return $this->value_object_factory->ast($ast);
    }
}

