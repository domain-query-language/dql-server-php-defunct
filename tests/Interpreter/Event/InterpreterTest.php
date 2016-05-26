<?php namespace Test\Interpreter\Event;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Event;
use App\Interpreter\ValueObjectRepository AS VoRepo;
use Test\Interpreter\ValueObject\ValueObjectRepository;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $factory;
    private $interpreter;

    public function setUp()
    {
        parent::setUp();
        $this->app()->bind(VoRepo::class, ValueObjectRepository::class);
        $this->factory = $this->app()->make(Event\Factory::class);
        $this->interpreter = $this->factory->ast($this->ast_repo->event());
    }
        
    public function test_build()
    {
        $context = new Context((object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ]);
        $event = $this->interpreter->interpret($context);
        $expected = (object)[
            'id'=>'3961fd8c-a054-41e1-a998-3fc9cfd8f0ad', 
            'payload'=> (object)[
                'shopper_id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
            ]
        ];
        
        $this->assertEquals($expected, $event);
    }
}
