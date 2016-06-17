<?php namespace Test\CommandStore;

use App\CommandStore\FullCommandStream;

class FullCommandStreamTest extends \Test\TestCase
{
    private $repository;
    
    public function setUp()
    {
        $this->repository = new CommandRepository();
    }
    
    public function test_iterates_through_list()
    {
        $this->assert_row_count(10);
    }

    private function assert_row_count($expected_count)
    {
        $this->repository->set_row_count($expected_count);
        $command_stream = new FullCommandStream($this->repository);
        
        $count = 0;
        foreach ($command_stream as $command) {
            $count++;
        } 
        $this->assertEquals($expected_count, $count);
    }

    public function test_empty_results()
    {
        $this->assert_row_count(0);
    }
    
    public function test_loads_next_chunk_when_reaches_end()
    {
        $this->assert_row_count(150);
    }
    
    public function test_stops_if_next_chunk_has_no_results()
    {
        $this->assert_row_count(100);
    }
}