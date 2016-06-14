<?php namespace App\Interpreter\Query;

interface AstRepository 
{
    public function store($ast);
    
    public function fetch($id);
}