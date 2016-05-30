<?php namespace App\Interpreter;

interface HandlerRepository 
{
    public function fetch_ast($command_id);
}

