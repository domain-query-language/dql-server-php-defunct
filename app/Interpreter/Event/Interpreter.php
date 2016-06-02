<?php namespace App\Interpreter\Event;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $event_id;
    private $aggregate_id;
    private $payload_interpreter;
    
    public function __construct($event_id, $aggregate_id, $payload_interpreter)
    {
        $this->event_id = $event_id;
        $this->aggregate_id = $aggregate_id;
        $this->payload_interpreter = $payload_interpreter;
    }
    
    public function interpret(Context $context)
    {
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->event_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=> $context->get_property('id'),
                'payload'=>$this->payload_interpreter->interpret($context)
            ]
        ]; 
        
        return $result;
    }
}

