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
        return $this->ast_repository->entity_root();
    }

    public function store($ast)
    {
        
    }
}
