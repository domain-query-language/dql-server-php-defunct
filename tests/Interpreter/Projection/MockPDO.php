<?php namespace Test\Interpreter\Projection;

class MockPDO extends \PDO
{
    public function __construct ()
    {
    }
    
    public function prepare($statement, $options = NULL)
    {
        return new MockPDOStatement();
    }
}
