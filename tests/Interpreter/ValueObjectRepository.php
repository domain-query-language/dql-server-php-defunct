<?php namespace Test\Interpreter;

class ValueObjectRepository implements \App\Interpreter\ValueObjectRepository
{
    private $ast_repo;
    
    public function __construct(\Test\Interpreter\Fake\AstRepository $ast_repo)
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
        if ($id == "dd7a3027-323c-484d-afc5-a9c6eb166221") {
            return $this->ast_repo->valueobject_boolean();
        }
        return $this->ast_repo->valueobject_validator();
    }
}
