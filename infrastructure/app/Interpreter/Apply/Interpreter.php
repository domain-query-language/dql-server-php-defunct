<?php namespace Infrastructure\App\Interpreter\Apply;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $arguments_interpreter;
    
    public function __construct($arguments_interpreter)
    {
        $this->arguments_interpreter = $arguments_interpreter;
    }
    
    public function interpret(Context $context)
    {       
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
}


