<?php namespace Test\Interpreter;

class HandlerRepository implements \App\Interpreter\HandlerRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\Fake\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch_ast($command_id)
    {
        return $this->ast_repository->handler();
    }
}