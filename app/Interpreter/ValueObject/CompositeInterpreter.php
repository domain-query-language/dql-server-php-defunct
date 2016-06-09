<?php namespace App\Interpreter\ValueObject;

class CompositeInterpreter
{
    private $keys;
    private $interpreters;
    
    public function __construct($interpreters, $keys)
    {
        $this->keys = $keys;
        $this->interpreters = $interpreters;
    }
    
    public function validate($value)
    {
        $value = (object)$value;
        $result = new \stdClass();
        foreach ($this->keys as $index=>$key) {
            if (!isset($value->$key)) {
                throw new PropertyException();
            }
            $sub_value = $value->$key;
            $result->$key = $this->interpreters[$index]->validate($sub_value);
        }
        return $result;
    }
}

