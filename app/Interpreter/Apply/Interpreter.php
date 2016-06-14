<?php namespace App\Interpreter\Apply;

class Interpreter
{    
    private $event_interpreter;
    private $event_handler_interpreter;
    
    public function __construct($event_interpreter, $event_handler_interpreter)
    {
        $this->event_interpreter = $event_interpreter;
        $this->event_handler_interpreter = $event_handler_interpreter;
    }
    
    public function interpret($root, $command)
    {       
        $event = $this->event_interpreter->interpret($root, $command);
        
        if ($this->event_handler_interpreter) {
            $this->event_handler_interpreter->modify($root, $event);
        }
        return $event;
    }
}


