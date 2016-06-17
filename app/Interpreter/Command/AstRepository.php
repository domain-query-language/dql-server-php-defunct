<?php namespace App\Interpreter\Command;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}