<?php namespace Test\DQLServer;

use App\DQLServer\Command;

class CommandTest extends \Test\TestCase
{    
    public function test_creating_command_without_timestamp_adds_one()
    {
        $command = new Command(1,2,3);
        $this->assertTrue(strtotime($command->timestamp) !== false);
    }
}


