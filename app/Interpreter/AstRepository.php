<?php namespace App\Interpreter;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}