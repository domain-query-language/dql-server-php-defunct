<?php namespace App\Interpreter\Validation\Validator;

use Respect\Validation\Validator as v;

class Interpreter
{
    private $validator;
    private $values;
    
    public function __construct($validator_name, $arguments)
    {      
        $v = v::create();
        
        $this->validator = call_user_func_array(
            [$v, $validator_name],
            $arguments
        );
    }
    
    public function check($value)
    {
        return $this->validator->validate($value);
    }
}

