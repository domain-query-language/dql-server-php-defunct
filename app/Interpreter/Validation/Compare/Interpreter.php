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
      
    public function check($input, $arguments=null)
    {
        $value = $this->get_value($input);
        $compare_to_value = $this->get_compare_to_value($arguments);
        if ($this->comparator == "="){
            return $value == $compare_to_value;
        }
        if ($this->comparator == "!="){
            return $value != $compare_to_value;
        }
        if ($this->comparator == ">"){
            return $value > $compare_to_value;
        }
        if ($this->comparator == "exists_in"){    
            return $this->is_in_list($value, $compare_to_value);
        }

        throw new Exception("Unknown comparator $this->comparator");
    }
    
    private function get_value($value)
    {
        if ($this->field != 'value') {
            $field = $this->field;
            return $value->$field;
        }
        return $value;
    }
    
    private function get_compare_to_value($arguments)
    {
        if (isset($this->value->literal)) {
            return $this->value->literal;
        }
        $property = $this->value->property[0];
        return $arguments->$property;
    }
    
    private function is_in_list($list, $value) 
    {
        $matches_list = array_filter($list, function($element) use ($value){
            if (isset($element->id)) {
                return ($element->id == $value);
            } else {
                return ($element == $value);
            }
        });
        return count($matches_list) > 0;
    }
}

