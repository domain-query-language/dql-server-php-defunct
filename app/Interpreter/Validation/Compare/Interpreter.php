<?php namespace App\Interpreter\Validation\Compare;

class Interpreter
{
    private $field;
    private $comparator;
    private $value;
    
    public function __construct($field, $comparator, $value)
    {
        $this->field = $field;
        $this->comparator = $comparator;
        $this->value = $value;
    }
    
    public function check($value, $arguments=[])
    {
        if ($this->field != 'value') {
            $field = $this->field;
            $value = $value->$field;
        }
        if ($this->comparator == "="){
            return $value == $this->get_value($arguments);
        }
        if ($this->comparator == "!="){
            return $value != $this->get_value($arguments);
        }
        if ($this->comparator == ">"){
            return $value > $this->get_value($arguments);
        }
        if ($this->comparator == "exists_in"){    
            $argument = $this->get_value($arguments);
            $list = array_filter($value, function($element) use ($argument){
                if (isset($element->id)) {
                    return ($element->id == $argument);
                } else {
                    return ($element == $argument);
                }
            });
            return count($list) > 0;
        }

        throw new Exception("Unknown comparator $this->comparator");
    }
    
    private function get_value($arguments)
    {
        if (isset($this->value->literal)) {
            return $this->value->literal;
        }
        $property = $this->value->property[0];
        return $arguments->$property;
    }
}

