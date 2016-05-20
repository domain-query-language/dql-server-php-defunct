<?php namespace Infrastructure\App\Interpreter\Update;

class Factory 
{   
    public function __construct()
    {
      
    }
    
    public function ast($ast)
    {
        return new Interpreter();
    }   
}