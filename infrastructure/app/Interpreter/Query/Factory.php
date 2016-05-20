<?php namespace Infrastructure\App\Interpreter\Query;

class Factory 
{       
    private $db_connection;
    private $sql_factory;
    
    public function __construct()
    {
        
    }
    
    public function ast($ast)
    {
        //$sql = $this->sql_factory->ast($ast);
        $sql = '';
        return new Interpreter($this->db_connection, $sql);
    }   
}