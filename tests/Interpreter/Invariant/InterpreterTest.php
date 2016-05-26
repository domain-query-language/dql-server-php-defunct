<?php namespace Test\Interpreter\Invariant;

use Infrastructure\App\Interpreter\Invariant;
use App\Interpreter\Context;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    protected $invariant;

    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->invariant();
        $this->app()->bind(\PDO::class, MockPDO::class);
        $invariant_factory = $this->app()->make(Invariant\Factory::class);
        $this->invariant = $invariant_factory->ast($ast);
    }
    
    public function test_passing_invariant()
    {
        $context = new Context();
        $context = $context->set_property('is_created', true);
        
        $this->assertTrue($this->invariant->interpret($context));
    }
    
    public function test_failing_invariant()
    {
        $context = new Context();
        $context = $context->set_property('is_created', false);
        
        $this->assertFalse($this->invariant->interpret($context));
    }
}
