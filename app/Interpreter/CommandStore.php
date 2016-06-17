<?php namespace App\Interpreter;

interface CommandStore
{
    public function fetch_all();
    
    public function store(array $commands);
}
