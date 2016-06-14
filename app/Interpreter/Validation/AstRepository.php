<?php namespace App\Interpreter\Validation;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}