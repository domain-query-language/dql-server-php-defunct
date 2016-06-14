<?php namespace App\Interpreter\Modification;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}