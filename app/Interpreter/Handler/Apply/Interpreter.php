<?php namespace App\Interpreter\Handler\Apply;

use App\Interpreter\Modification;

class Interpreter
{    
    private $event_interpreter;
    private $event_id;
    private $modification;
    
    public function __construct($event_interpreter, $event_id, Modification\Modifier $modification)
    {
        $this->event_interpreter = $event_interpreter;
        $this->event_id = $event_id;
        $this->modification = $modification;
    }
    
    public function interpret($root, $command)
    {       
        $event = $this->event_interpreter->make_event($root, $command);
        $this->modification->modify($this->event_id, $root, $command);
        return $event;
    }
}


