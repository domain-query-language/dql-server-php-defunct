<?php namespace Test\Interpreter\Projection;

class MockPDOStatement extends \PDOStatement
{
    private static $seen_ids = [];
    private $result = [];
        
    public function execute($input_parameters = null)
    {
        if (in_array($input_parameters[0], static::$seen_ids)) {
            $this->result = [1];
        } else {
            $this->result = [];
        }
        static::$seen_ids[] = $input_parameters[0];
    }
    
    public function fetchAll($how = NULL, $class_name = NULL, $ctor_args = NULL)
    {
        return $this->result;
    }
}
