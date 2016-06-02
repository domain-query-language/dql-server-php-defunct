<?php namespace App\Interpreter\Apply;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $arguments_interpreter;
    private $event_interpreter;
    private $event_handler_interpreter;
    
    public function __construct($arguments_interpreter, $event_interpreter, $event_handler_interpreter)
    {
        $this->arguments_interpreter = $arguments_interpreter;
        $this->event_interpreter = $event_interpreter;
        $this->event_handler_interpreter = $event_handler_interpreter;
    }
    
    public function interpret(Context $context)
    {       
        $arguments_context = $this->arguments_interpreter->interpret($context);
        
        $event = $this->event_interpreter->interpret($arguments_context);
        
        $context->set_property('event', $event->domain->payload);
        $this->event_handler_interpreter->interpret($context);
        
        return $event;
    }
}


