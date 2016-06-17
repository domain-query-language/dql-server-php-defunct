<?php namespace Test\Interpreter\Validation\Command;

use App\Interpreter\Command\Interpreter;
use App\DQLServer\Command;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $interpreter;

    public function setUp()
    {
        parent::setUp();
        $this->interpreter = $this->app->make(Interpreter::class);
    }
        
    public function test_build()
    {
        $command_id = "2af65a9c-5a1d-46d0-b2be-5a102da14cab";
        $aggregate_id = "2ea22141-89f4-4216-88f6-81a67cb20d20";
        $payload = (object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ];
        $command = new Command($command_id, $aggregate_id, $payload);
        
        $command_dto = $this->interpreter->transform($command);
        
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
        
        $this->assertEquals($expected, $command_dto);
    }
}
