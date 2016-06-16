<?php namespace App\Interpreter\Validation\Compare;

class Interpreter
{
    private $field;
    private $comparator;
    private $value;
    
    public function __construct($left, $comparator, $right)
    {
        $this->left = $left;
        $this->comparator = $comparator;
        $this->right = $right;
    }
      
    public function check($input, $arguments=null)
    {
        $left_value = $this->get_value($this->left, $input);
        $right_value = $this->get_value($this->right, $arguments);
        
        if ($this->comparator == "="){
            return $left_value == $right_value;
        }
        if ($this->comparator == "!="){
            return $left_value != $right_value;
        }
        if ($this->comparator == ">"){
            return $left_value > $right_value;
        }
        if ($this->comparator == "exists_in"){    
            return $this->is_in_list($left_value, $right_value);
        }

        throw new Exception("Unknown comparator $this->comparator");
    }
    
    private function get_value($ast, $input)
    {
        if (isset($ast->literal)) {
            return $ast->literal;
        }
        
        $property = $ast->property[0];
        if ($property != 'value') {
            return $input->$property;
        }
        
        return $input;
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

