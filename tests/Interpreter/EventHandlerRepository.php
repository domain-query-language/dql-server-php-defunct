<?php namespace Test\Interpreter;

class EventHandlerRepository implements \App\Interpreter\EventHandlerRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch_ast($id)
    {
        if ($id == "3961fd8c-a054-41e1-a998-3fc9cfd8f0ad") {
            return $this->ast_repository->event_handler_is_created();
        }
    }
}