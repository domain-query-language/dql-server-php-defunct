<?php namespace Test\Interpreter\Validation\Command;

use App\Interpreter\Command\Factory;
use App\DQLServer\Command;

class FactoryTest extends \Test\Interpreter\TestCase
{
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = $this->app->make(Factory::class);
    }
        
    public function test_build()
    {
        $command_id = "2af65a9c-5a1d-46d0-b2be-5a102da14cab";
        $aggregate_id = "2ea22141-89f4-4216-88f6-81a67cb20d20";
        $payload = (object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ];
        
        $command = new Command($command_id, $aggregate_id, $payload);
        
        $actual = $this->factory->dql_command($command);
        
        $expected = (object)[
            "schema"=> (object)[
                'id'=>'2af65a9c-5a1d-46d0-b2be-5a102da14cab',
                'aggregate_id' => '01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "aggregate_id"=> "2ea22141-89f4-4216-88f6-81a67cb20d20",
                'payload'=>(object)['shopper_id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6']
            ]
        ];
        
        $this->assertEquals($expected, $actual);
    }
}
