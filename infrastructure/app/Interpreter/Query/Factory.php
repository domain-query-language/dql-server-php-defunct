<?php namespace Infrastructure\App\Interpreter\Query;

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