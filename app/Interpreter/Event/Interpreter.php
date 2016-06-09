<?php namespace App\Interpreter\Event;

class Interpreter
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
    
    public function interpret($value)
    {
        $value = (object)$value;
        $payload = isset($value->payload) ? $value->payload : [];
        
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->event_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=>$value->aggreggate_id,
                'payload'=>$this->payload_interpreter->validate($payload)
            ]
        ]; 
        
        return $result;
    }
}

