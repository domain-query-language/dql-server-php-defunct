<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\Command\Factory;
use App\DQLServer\Dispatcher;
use App\DQLServer\Command;

class DQLServerDispatcher implements Dispatcher
{
    private $command_factory;
    private $dispatcher;
    
    public function __construct( 
        EventLockerDispatcher $dispatcher,
        Factory $command_factory
    )
    {
        $this->command_factory = $command_factory;
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch(Command $dql_command)
    {
        $command = $this->command_factory->dql_command($dql_command);
        return $this->dispatcher->dispatch($command);
    }
}