<?php namespace App\Interpreter\Validation;

class InMemoryAstRepository implements AstRepository
{
    private $asts = array();
    
    public function store($ast)
    {
        $this->asts[$ast->id] = $ast;
    }
    
    public function fetch($id)
    {
        if (!isset($this->asts[$id])) {
            throw new Exception();
        }
        return $this->asts[$id];
    }
}