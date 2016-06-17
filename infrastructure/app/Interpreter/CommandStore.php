<?php namespace Infrastructure\App\Interpreter;

class CommandStore implements \App\Interpreter\CommandStore
{
    private $store;
    private $builder;
    
    public function __construct(
        \App\CommandStore\CommandStore $store,
        \App\CommandStore\CommandBuilder $builder
    )
    {
        $this->store = $store;
        $this->builder = $builder;
    }

    public function store(array $commands)
    {
        $transformed = array_map(function($command){
            $this->builder->set_aggregate_id($command->domain->aggregate_id)
                ->set_schema_command_id($command->schema->id)
                ->set_schema_aggregate_id($command->schema->aggregate_id)
                ->set_payload($command->domain->payload);
            
            return $this->builder->build();
                    
        }, $commands);
        
        $this->store->store($transformed);
    }

    public function fetch_all()
    {
        return $this->store->all();
    }

}
