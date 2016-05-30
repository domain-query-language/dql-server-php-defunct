<?php namespace Infrastructure\App\Interpreter\Command;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $command_id;
    private $aggregate_id;
    private $payload_interpreter;
    
    public function __construct($command_id, $aggregate_id, $payload_interpreter)
    {
        $this->command_id = $command_id;
        $this->aggregate_id = $aggregate_id;
        $this->payload_interpreter = $payload_interpreter;
    }
    
    public function interpret(Context $context)
    {
        $payload_context = new Context($context->get_property('payload'));
        
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->command_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=> $context->get_property('id'),
                'payload'=>$this->payload_interpreter->interpret($payload_context)
            ]
        ]; 
        return $result;
    }
}

