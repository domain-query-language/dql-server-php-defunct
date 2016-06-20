<?php namespace App\Interpreter\Validation\ValueObject;

use App\Interpreter\Validation\Checker;
use App\Interpreter\AstRepository;

class Factory 
{    
    private $check_factory;
    private $ast_repo;
    
    public function __construct(Checker\Factory $check_factory, AstRepository $ast_repo)
    {
        $this->check_factory = $check_factory;
        $this->ast_repo = $ast_repo;
    }
    
    public function ast($ast)
    {
        if (isset($ast->check)) {
           return new SimpleInterpreter($this->check_factory->ast($ast->check));
        }
        if (isset($ast->children)) {
           return $this->make_composite($ast);
        }
        if (isset($ast->collection_of)) {
           return $this->make_collection($ast);
        }
    } 
    
    private function make_composite($ast)
    {
        $children = $ast->children;
        $interpreters = [];
        foreach ($children as $vo_id) {
            $vo_ast = $this->ast_repo->fetch($vo_id);
            $interpreters[] = $this->ast($vo_ast);
        }
        
        return new CompositeInterpreter($interpreters, array_keys((array)$children));
    }
    
    private function make_collection($ast)
    {
        $vo_ast = $this->ast_repo->fetch($ast->collection_of);
        $value_object_interpreter = $this->ast($vo_ast);
        return new CollectionInterpreter($value_object_interpreter);
    }
}

