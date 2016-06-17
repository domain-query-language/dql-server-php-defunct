<?php namespace Test\CommandStore;

use App\CommandStore\CommandStreamFactory;

class CommandStreamFactoryTest extends \Test\TestCase 
{
    private $stream_factory;
    
    public function setUp()
    {
        parent::setUp();
        $repository = new CommandRepository();
        $this->stream_factory = new CommandStreamFactory($repository);
    }

    public function test_get_full_stream()
    {
        $stream = $this->stream_factory->all();
        $this->assertInstanceOf(\App\CommandStore\FullCommandStream::class, $stream);
    }
}