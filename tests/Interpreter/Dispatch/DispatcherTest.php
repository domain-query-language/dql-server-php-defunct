<?php namespace Test\Interpreter\Dispatch;

use App\Interpreter\Dispatch;
use App\Interpreter\Handler\Invariant;

class DispatcherTest extends \Test\Interpreter\TestCase
{
    private $command;
    private $dispatcher;
    private $event_store;
    private $command_store;
    private $command_id;

    public function setUp()
    {
        parent::setUp();
                
        $this->event_store = $this->app->make(\App\Interpreter\EventStore::class);
        $this->event_store->clear();
        
        $this->command_store = $this->app->make(\App\Interpreter\CommandStore::class);
        
        $this->dispatcher = $this->app->make(Dispatch\Dispatcher::class);
                
        $this->command_id = "2af65a9c-5a1d-46d0-b2be-5a102da14cab";
        
        $this->command = (object)[
            "schema" => (object)[
                'id' => '2af65a9c-5a1d-46d0-b2be-5a102da14cab',
                'aggregate_id' => 'e5cbb69e-4581-4095-b77c-2e9eb1c8af17'
            ],
            "domain" => (object)[
                'id' => $this->command_id,
                "aggregate_id" => "2ea22141-89f4-4216-88f6-81a67cb20d20",
                'payload' => (object)['shopper_id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6']
            ]
        ];
    }
            
    public function test_events_stores_events_on_success()
    {
        $events = $this->dispatcher->dispatch($this->command);
        
        $this->assertEquals($events, $this->event_store->fetch('', ''));
    }
    
    public function test_events_are_decorated_with_aggregate_id()
    {
        $events = $this->dispatcher->dispatch($this->command);
        
        foreach ($events as $event) {
            $this->assertEquals($this->command_id, $event->domain->command_id);
        }
    }
    
    public function test_that_events_are_loaded_from_the_stream_and_replayed_to_build_state()
    {        
        $this->dispatcher->dispatch($this->command);
        
        $this->setExpectedException(Invariant\Exception::class);
        
        // This command has been run once, if the events are replayed successfully, 
        // then replaying it again will break it
        $this->dispatcher->dispatch($this->command);
    } 
    
    public function test_dispatcher_stores_command_on_success()
    {
        $this->assertEquals([$this->command], $this->command_store->fetch_all());
    }
}
