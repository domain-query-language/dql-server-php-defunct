<?php namespace Test\Interpreter;

class ValueObjectRepository implements \App\Interpreter\ValueObjectRepository
{
    private $ast_repo;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repo)
    {
        $this->ast_repo = $ast_repo;
    }
    
    public function fetch_ast($id)
    {
        if ($id == "33490f62-8be7-4e74-b130-f2f6bc42567c") {
            return $this->ast_repo->valueobject_composite();
        } 
        if ($id == "4ea61742-409a-48b6-9563-2587c681f838") {
            return $this->ast_repo->valueobject_simple();
        } 
        return $this->ast_repo->valueobject_validator();
    }
}
