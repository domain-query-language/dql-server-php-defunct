<?php namespace Test\CommandStore;

use App\CommandStore\CommandBuilder;
use App\CommandStore\Command;
use App\CommandStore\IDGenerator;
use App\CommandStore\DateTimeGenerator;
use App\CommandStore\Schema;

class CommandBuilderTest extends \Test\TestCase
{
    private $command_builder;
    private $command;
    
    public function setUp()
    {
        $stub_id_generator = $this->getMockBuilder(IDGenerator::class)->getMock();
        $stub_id_generator->method('generate')->willReturn("87484542-4a35-417e-8e95-5713b8f55c8e");
        
        $stub_datetime_generator = $this->getMockBuilder(DateTimeGenerator::class)->getMock();
        $stub_datetime_generator->method('generate')->willReturn('2014-10-10 12:12:12');
        
        $this->command_builder = new CommandBuilder($stub_id_generator, $stub_datetime_generator);
        $this->command_builder->set_payload((object)['value'=>true])
            ->set_schema_event_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f");
        
        $this->command = $this->command_builder->build();
    }
    
    public function test_builds_class()
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }
    
    public function test_gives_event_id()
    {
        $this->assertEquals("87484542-4a35-417e-8e95-5713b8f55c8e", $this->command->event_id);
    }
    
    public function test_gives_occured_at()
    {
        $this->assertEquals("2014-10-10 12:12:12", $this->command->occured_at);
    }
   
    public function test_populates_schema()
    {
        $expected = new Schema();
        $expected->event_id = "14c3896d-092e-4370-bf72-2093facc9792";
        $expected->aggregate_id = "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f";
      
        $this->assertEquals($expected, $this->command->schema);
    }
    
    public function test_populates_domain()
    {
        $aggregate_id = 'a955d32b-0130-463f-b3ef-23adec9af469';
        $payload = (object)['value'=>true];
        
        $this->assertEquals($aggregate_id, $this->command->aggregate_id);
        $this->assertEquals($payload, $this->command->payload);
    }
    
    public function test_resets_after_build()
    {
        $command = $this->command_builder->build();
        
        $this->assertNull($command->aggregate_id);
        $this->assertNull($command->payload);
        $this->assertEquals(new Schema(), $command->schema);
    }
    
    public function test_can_set_id()
    {
        $id = 'a7285082-a50c-4593-8b13-06a0fd75ba71';
        $this->command_builder->set_event_id($id);
        
        $command = $this->command_builder->build();
        $this->assertEquals($id, $command->event_id);
    }
    
    public function test_can_set_occurred_at()
    {
        $datetime = "2014-10-10 12:12:12";
        $this->command_builder->set_occured_at($datetime);
        
        $command = $this->command_builder->build();
        $this->assertEquals($datetime, $command->occured_at);
    }
    
}