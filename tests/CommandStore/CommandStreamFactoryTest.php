<?php namespace Test\CommandStore;

use App\EventStore\CommandStreamFactory;

class CommandStreamFactoryTest extends \Test\TestCase 
{
    private $event_stream_factory;
    
    public function setUp()
    {
        parent::setUp();
        $event_repository = new CommandRepository();
        $this->event_stream_factory = new CommandStreamFactory($event_repository);
    }

    public function test_get_full_stream()
    {
        $stream = $this->event_stream_factory->all();
        $this->assertInstanceOf(\App\CommandStore\CommandStream::class, $stream);
    }
}