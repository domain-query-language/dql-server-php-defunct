<?php namespace Infrastructure\App\Interpreter\Command;

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
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $result = new \stdClass();
        $result->id = $this->command_id;
        $result->aggregate_id = $this->aggregate_id;
        $result->payload = $this->payload_interpreter->interpret($context);
        return $result;
    }
}

