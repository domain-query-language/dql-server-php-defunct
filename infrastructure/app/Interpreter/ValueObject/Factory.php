<?php namespace Infrastructure\App\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\Check;
use App\Interpreter\ValueObjectRepository;

class Factory 
{    
    private $check_factory;
    private $value_object_repo;
    
    public function __construct(
        Check\Factory $check_factory,
        ValueObjectRepository $value_object_repo
    )
    {
        $this->check_factory = $check_factory;
        $this->value_object_repo = $value_object_repo;
    }
    
    public function ast($ast)
    {
        if (!isset($ast->children)) {
           return new SimpleInterpreter($this->check_factory->ast($ast->check));
        }
        $children = $ast->children;
        $interpreters = [];
        foreach ($children as $vo_id) {
            $vo_ast = $this->value_object_repo->fetch_ast($vo_id);
            $interpreters[] = $this->ast($vo_ast);
        }
        
        return new CompositeInterpreter($interpreters, array_keys((array)$children));
    } 
}

