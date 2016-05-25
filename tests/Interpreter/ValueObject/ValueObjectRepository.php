<?php namespace Test\Interpreter\ValueObject;

class ValueObjectRepository implements \App\Interpreter\ValueObjectRepository
{
    private $ast_repo;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repo)
    {
        $this->ast_repo = $ast_repo;
    }
    
    public function fetch_ast($id)
    {
        return $this->ast_repo->valueobject_simple();
    }
}
