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
        $this->stub_command_repo = $this->mock(CommandRepository::class);
        $this->stub_command_stream_factory = $this->stub(CommandStreamFactory::class);
        $this->command_store = new CommandStore(
            $this->stub_command_repo->reveal(), 
            $this->stub_command_stream_factory->reveal()
        );
    }

    public function test_takes_in_data()
    {
        $data = ['data'];
        
        $this->stub_command_repo->store($data)
            ->shouldBeCalled();

        $this->command_store->store($data);
    }
    
    public function test_can_fetch_full_stream()
    {
        $stream = 'stream';
        $this->stub_command_stream_factory->all()
             ->willReturn($stream);
        
        $this->assertEquals($stream, $this->command_store->all());
    }
}