<?php namespace Infrastructure\App\Interpreter\Event;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $event_id;
    private $payload_interpreter;
    
    public function __construct($event_id, $payload_interpreter)
    {
        $this->event_id = $event_id;
        $this->payload_interpreter = $payload_interpreter;
    }
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $result = new \stdClass();
        $result->id = $this->event_id;
        $result->payload = $this->payload_interpreter->interpret($context);
        return $result;
    }
}

