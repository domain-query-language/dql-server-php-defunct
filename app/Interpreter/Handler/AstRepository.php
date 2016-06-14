<?php namespace App\Interpreter\Handler;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}