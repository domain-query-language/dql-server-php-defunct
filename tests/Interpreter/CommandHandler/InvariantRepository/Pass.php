<?php namespace Test\Interpreter\CommandHandler\InvariantRepository;

class Pass implements \App\Interpreter\InvariantRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch_ast($id)
    {
        return $this->ast_repository->invariant();
    }
}