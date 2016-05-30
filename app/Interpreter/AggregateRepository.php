<?php namespace App\Interpreter;

interface AggregateRepository 
{
    public function fetch_ast($id);
}

