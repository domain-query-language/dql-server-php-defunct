<?php namespace Test\Interpreter\Check;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Compare;

class CompareTest extends \Test\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/Check/compare-ast.json');
        $factory = $this->app()->make(Compare\Factory::class);
        $this->interpreter = $factory->ast($ast->condition);
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
