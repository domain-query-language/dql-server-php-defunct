<?php namespace App\CommandStore;

class CommandBuilder
{
    private $id_generator;
    private $command;
    
    public function __construct(IDGenerator $id_generator)
    {
        $this->id_generator = $id_generator;
        $this->setup_fresh();
    }
    
    private function setup_fresh()
    {
        $this->command = new Command(); 
        $this->command->command_id = null;
        $this->command->aggregate_id = null;
        $this->command->schema = new Schema();
        $this->occured_at = null;
        $this->payload = null;
    }
    
    public function set_command_id($id)
    {
        $this->command->command_id = $id;
        return $this;
    }
    
    public function set_aggregate_id($id)
    {
        $this->command->aggregate_id = $id;
        return $this;
    }
    
    public function set_payload($payload)
    {
        $this->command->payload = $payload;
        return $this;
    }
    
    public function set_schema_command_id($id)
    {
        $this->command->schema->command_id = $id;
        return $this;
    }
    
    public function set_schema_aggregate_id($id)
    {
        $this->command->schema->aggregate_id = $id;
        return $this;
    }
    
    public function set_occured_at($occured_at)
    {
        $this->command->occured_at = $occured_at;
        return $this;
    }
    
    public function build()
    {
        $command = $this->command;
        $command->command_id = $command->command_id ?: $this->id_generator->generate();
        
        $this->setup_fresh();
        
        return $command;
    }
}
