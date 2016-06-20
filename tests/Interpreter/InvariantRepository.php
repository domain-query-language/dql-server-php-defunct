<?php namespace Test\Interpreter;

class InvariantRepository implements \App\Interpreter\InvariantRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\Fake\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch_ast($id)
    {
        return $this->ast_repository->invariant();
    }
}