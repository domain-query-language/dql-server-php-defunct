<?php namespace Infrastructure\App\Interpreter\Apply;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $check_interpreter;
    private $arguments_interpreter;
    
    public function __construct($check_interpter, $arguments_interpreter)
    {
        $this->check_interpreter = $check_interpter;
        $this->arguments_interpreter = $arguments_interpreter;
    }
    
    public function interpret(Context $context)
    {
        if (!$this->check_interpreter->interpret($context)) {
           return; 
        }
        
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
}


