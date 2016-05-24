<?php namespace Infrastructure\App\Interpreter\Invariant;

use Infrastructure\App\Interpreter\Check;
use Infrastructure\App\Interpreter\Query;
use Infrastructure\App\Interpreter\NullInterpreter;

class Factory 
{     
    private $check_factory;
    private $query_factory;
    
    public function __construct(
        Check\Factory $check_factory,
        Query\Factory $query_factory)
    {
        $this->check_factory = $check_factory;
        $this->query_factory = $query_factory;
    }
    
    public function ast($ast)
    {
        $query = new NullInterpreter();
        if ($ast->query) {
            $query = $this->query_factory->ast($ast);
        }
        $check = $this->check_factory->ast($ast->check);
        return new Interpreter($query, $check);
    }
}



