<?php namespace Test\Interpreter\Check;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Compare;

class CompareTest extends \Test\Interpreter\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->valueobject_simple();
        $factory = $this->app()->make(Compare\Factory::class);
        $this->interpreter = $factory->ast($ast->check->condition);
    }
    
    public function test_pass()
    {
        $context = new Context(['value'=>1]);
        
        $this->assertTrue($this->interpreter->interpret($context));
    }
    
    public function test_fail()
    {
        $context = new Context(['value'=>-1]);

        $this->assertFalse( $this->interpreter->interpret($context) );
    }
}
