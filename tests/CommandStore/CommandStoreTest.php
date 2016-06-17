<?php namespace Test\CommandStore;

use App\CommandStore\CommandStore;
use App\CommandStore\CommandRepository;
use App\CommandStore\CommandStreamFactory;

class CommandStoreTest extends \Test\TestCase 
{
    private $stub_command_repo;
    private $stub_command_stream_factory;
    private $command_store;
    
    public function setUp()
    {
        $this->stub_command_repo = $this->getMockBuilder(CommandRepository::class)
                ->disableOriginalConstructor()->getMock();
        $this->stub_command_stream_factory = $this->getMockBuilder(CommandStreamFactory::class)
                ->disableOriginalConstructor()->getMock();
        $this->command_store = new CommandStore($this->stub_command_repo, $this->stub_command_stream_factory);
    }

    public function test_takes_in_data()
    {
        $data = ['data'];
        
        $this->stub_command_repo->expects($this->once())
                 ->method('store')
                 ->with($this->equalTo($data));

        $this->command_store->store($data);
    }
    
    public function test_can_fetch_full_stream()
    {
        $stream = 'stream';
        $this->stub_command_stream_factory->method('all')
             ->willReturn($stream);
        
        $this->assertEquals($stream, $this->command_store->all());
    }
}