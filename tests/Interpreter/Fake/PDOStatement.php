<?php namespace Test\Interpreter\Fake;

class PDOStatement extends \PDOStatement
{
    private static $seen_ids = [];
    private $rows = [];
        
    public function execute($input_parameters = null)
    {
        $row = (object)['cart_count'=>0];
        if (in_array($input_parameters[0], static::$seen_ids)) {
            $row->cart_count = 1;
        }
        $this->rows = [$row];
        static::$seen_ids[] = $input_parameters[0];
    }
    
    public function fetchAll($how = NULL, $class_name = NULL, $ctor_args = NULL)
    {
        return $this->rows;
    }
}
