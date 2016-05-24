<?php namespace Infrastructure\App\Interpreter\ValueObject;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $compare;
    
    public function __construct(\App\Interpreter\Interpreter $compare)
    {
        $this->compare = $compare;
    }
    
    public function interpret(Context $context)
    { 
        if (!$this->compare->interpret($context)) {
            throw new Exception();
        }
        return $context->get_property(['value']);
    }
}



