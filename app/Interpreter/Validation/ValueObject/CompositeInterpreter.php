<?php namespace App\Interpreter\Validation\ValueObject;

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
        $object = (object)$value;
        $result = new \stdClass();
        foreach ($this->keys as $index=>$key) {
            if (!isset($object->$key)) {
                throw new PropertyException();
            }
            $sub_value = $object->$key;
            $result->$key = $this->interpreters[$index]->validate($sub_value);
        }
        return $result;
    }
    
    public function check($value)
    {
        $object = (object)$value;
        foreach ($this->keys as $index=>$key) {
            if (!isset($object->$key)) {
                return false;
            }
            $sub_value = $object->$key;
            if ($this->interpreters[$index]->validate($sub_value)) {
                return false;
            }
        }
        return true;
    }
}

