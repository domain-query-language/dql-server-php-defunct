<?php namespace Test\Interpreter\Projection;

class MockPDOStatement extends \PDOStatement
{
    public function __construct ()
    {
    }
    
    public function execute($input_parameters = null)
    {
       
    }
    
    public function fetchAll($how = NULL, $class_name = NULL, $ctor_args = NULL)
    {
        return [];
    }
}
