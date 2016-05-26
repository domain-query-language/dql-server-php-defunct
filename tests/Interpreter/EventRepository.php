<?php namespace Test\Interpreter;

class EventRepository implements \App\Interpreter\EventRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch_ast($id)
    {
        return $this->ast_repository->event_empty();
    }
}
