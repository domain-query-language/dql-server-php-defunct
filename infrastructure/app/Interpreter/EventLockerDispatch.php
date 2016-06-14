<?php namespace Infrastructure\App\Interpreter;

use App\EventStore\EventStreamLocker;
use App\EventStore\StreamID;
use App\Interpreter\Dispatch;

class EventLockerDispatch
{
    private $event_stream_locker;
    private $dispatch_interpreter;
    
    public function __construct(
        EventStreamLocker $event_stream_locker,
        Dispatch\Interpreter $dispatch_interpreter
    ){
        $this->event_stream_locker = $event_stream_locker;
        $this->dispatch_interpreter = $dispatch_interpreter;
    }
    
    public function interpret($command)
    {
        $schema_id = $command->schema->aggregate_id;
        $domain_id = $command->domain->aggregate_id;
        
        $stream_id = new StreamID($schema_id, $domain_id);
        try {
            $this->event_stream_locker->lock($stream_id);
            $events = $this->dispatch_interpreter->interpret($command);
            $this->event_stream_locker->unlock($stream_id);
            return $events;
        } catch (\Exception $ex) {
            $this->event_stream_locker->unlock($stream_id);
            throw $ex;
        }
        
    }
}

