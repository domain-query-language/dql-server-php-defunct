<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\Command\Interpreter;
use App\DQLServer\Dispatcher;
use App\DQLServer\Command;

class DQLServerDispatcher implements Dispatcher
{
    private $command_transformer;
    private $dispatcher;
    
    public function __construct( 
        EventLockerDispatcher $dispatcher,
        Interpreter $command_transformer
    )
    {
        $this->command_transformer = $command_transformer;
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch(Command $dql_command)
    {
        $command = $this->command_transformer->transform($dql_command);
        
        return $this->dispatcher->dispatch($command);
    }
}