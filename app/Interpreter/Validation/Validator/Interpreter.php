<?php namespace App\Interpreter\Validation\Validator;

use Respect\Validation\Validator as v;

class Interpreter
{
    private $validator;
    private $left;
    
    public function __construct($left, $right)
    {      
        $this->left = $left;
        
        $validator = $this->translate($right);
        
        $v = v::create();
        $this->validator = call_user_func_array(
            [$v, $validator->validator],
            $validator->arguments
        );
    }
    
    private function translate($validator)
    {
        if ($validator->validator != 'count') {
            return $validator;
        }
        $validator->validator = 'length';
        $value = $validator->arguments[0];
        $validator->arguments = [$value, $value, true];
        return $validator;
    }
    
    public function check($input)
    {
        $left_value = $this->get_value($this->left, $input);
        return $this->validator->validate($left_value);
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
}

