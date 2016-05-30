<?php namespace Test\Interpreter\Aggregate;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Aggregate;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $ast = $this->ast_repo->aggregate();
        
        $factory = $this->app()->make(Aggregate\Factory::class);
        
        $this->interpreter = $factory->ast($ast);
    }
        
    public function test_builds_root_entity()
    {
        $context = new Context((object)['aggregate_id' => "2ea22141-89f4-4216-88f6-81a67cb20d20"]);
        
        $entity = $this->interpreter->interpret($context);
        
        $expected = (object)[
            'id' => '2ea22141-89f4-4216-88f6-81a67cb20d20',
            'is_created' => false
        ];
        
        $this->assertEquals($expected, $entity);
    }
}
