<?php namespace App\Interpreter\Validation\ValueObject;

use App\Interpreter\Validation\Checker;
use App\Interpreter\Validation\AstRepository;

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
        if (!isset($ast->children)) {
           return new SimpleInterpreter($this->check_factory->ast($ast->check));
        }
        $children = $ast->children;
        $interpreters = [];
        foreach ($children as $vo_id) {
            $vo_ast = $this->ast_repo->fetch($vo_id);
            $interpreters[] = $this->ast($vo_ast);
        }
        
        return new CompositeInterpreter($interpreters, array_keys((array)$children));
    } 
}

