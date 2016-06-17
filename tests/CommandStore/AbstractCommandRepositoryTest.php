<?php namespace Test\EventStore;

use Test\DBTestCase;
use App\CommandStore\CommandBuilder;
use App\CommandStore\CommmandRepository;

abstract class AbstractEventRepositoryTest extends DBTestCase
{
    protected $builder;
    protected $repo;
    protected $commands = [];
    
    public function setUp()
    {
        parent::setUp();
        
        /** @var CommandBuilder */
        $this->builder = $this->app->make(CommandBuilder::class);
        
        $this->repo = $this->build_event_repository();
        
        $this->commands[] = $this->make_command("c91942f1-3c94-4900-a3b0-4497311e3503", "a955d32b-0130-463f-b3ef-23adec9af469");
        $this->commands[] = $this->make_command("b2527176-edcc-4db9-818a-9a4e5767f350", "a955d32b-0130-463f-b3ef-23adec9af469");
        $this->commands[] = $this->make_command("11386b92-690e-4e15-8418-ff3c1688bad8", "343d56cf-6c4d-4d5d-9040-c7dd74ab65b9");
        
        $this->repo->store($this->commands);        
    }
    
    private function make_command($event_id, $aggregate_id)
    {
        $this->builder->set_command_id($event_id)
            ->set_aggregate_id($aggregate_id)
            ->set_schema_command_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f")
            ->set_occured_at("2014-10-10 12:12:12")
            ->set_payload((object)['value'=>true]);
        
        return $this->builder->build();
    }
    
    /** @return CommmandRepository */
    abstract protected function build_command_repository();
        
    public function test_fetch_all()
    {
        $results = $this->repo->fetch_all(0, 10);
        
        $this->assertEquals($this->commands, $results);
    }
}