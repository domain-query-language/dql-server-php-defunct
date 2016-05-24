<?php namespace Test\Interpreter\Invariant;

use Infrastructure\App\Interpreter\Invariant;
use App\Interpreter\Context;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\TestCase
{
    protected $invariant;

    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/Invariant/invariant-ast.json');
        $this->app()->bind(\PDO::class, MockPDO::class);
        $invariant_factory = $this->app()->make(Invariant\Factory::class);
        $this->invariant = $invariant_factory->ast($ast);
    }
    
    public function test_passing_invariant()
    {
        $context = new Context();
        $context = $context->set_property('is_checked_out', false);
        
        $this->assertTrue($this->invariant->interpret($context));
    }
    
    public function test_failing_invariant()
    {
        $context = new Context();
        $context = $context->set_property('is_checked_out', true);
        
        $this->assertFalse($this->invariant->interpret($context));
    }
}
