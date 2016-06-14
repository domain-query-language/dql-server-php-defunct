<?php namespace App\Interpreter\Validation\ValueObject;

class CollectionInterpreter
{
    private $interpreter;
    
    public function __construct($interpreter)
    {
        $this->interpreter = $interpreter;
    }
    
    public function validate($list)
    {
        $interpreter = $this->interpreter;
        return array_map(function($value) use ($interpreter){
            return $interpreter->validate($value);
        }, $list);
    }
    
    public function check($list)
    {
        $interpreter = $this->interpreter;
        $filtered = array_filter($list, function($value) use ($interpreter){
            return $interpreter->check($value);
        });
        
        return count($list) == count($filtered);
    }
}

