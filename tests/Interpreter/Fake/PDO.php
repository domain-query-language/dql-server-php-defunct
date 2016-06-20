<?php namespace Test\Interpreter\Fake;

class PDO extends \PDO
{
    public function __construct ()
    {
    }
    
    public function prepare($statement, $options = NULL)
    {
        return new PDOStatement();
    }
}
