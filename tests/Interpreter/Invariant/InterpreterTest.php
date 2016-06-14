<?php namespace Test\Interpreter\Invariant;

use App\Interpreter\Invariant;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    protected $invariant;

    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->invariant();
        $this->app->bind(\PDO::class, MockPDO::class);
        $invariant_factory = $this->app->make(Invariant\Factory::class);
        $this->invariant = $invariant_factory->ast($ast);
    }
    
    public function test_passing_invariant()
    {
        $root = (object)['is_created'=> true];
        
        $this->assertTrue($this->invariant->interpret($root));
    }
    
    public function test_failing_invariant()
    {
        $root = (object)['is_created'=> false];
        
        $this->assertFalse($this->invariant->interpret($root));
    }
}
