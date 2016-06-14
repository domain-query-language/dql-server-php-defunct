<?php namespace Test\Interpreter;

class EntityRepository implements \App\Interpreter\Validation\AstRepository
{
    private $ast_repository;
    
    public function __construct(\Test\Interpreter\AstRepository $ast_repository)
    {
        $this->ast_repository = $ast_repository;
    }
    
    public function fetch($id)
    {
        if ($id == "9be14fd0-80aa-4e82-bd30-df031a51f626") {
            return $this->ast_repository->event_empty();
        }
        if ($id == "3961fd8c-a054-41e1-a998-3fc9cfd8f0ad") {
            return $this->ast_repository->event();
        }
        return $this->ast_repository->entity_root();
    }

    public function store($ast)
    {
        
    }
}
