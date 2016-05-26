<?php namespace Infrastructure\App\Interpreter\Apply;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $arguments_interpreter;
    private $event_interpreter;
    
    public function __construct($arguments_interpreter, $event_interpreter)
    {
        $this->arguments_interpreter = $arguments_interpreter;
        $this->event_interpreter = $event_interpreter;
    }
    
    public function interpret(Context $context)
    {       
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $event = $this->event_interpreter->interpret($context);
        
        return $event;
    }
}


