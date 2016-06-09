<?php namespace Test\Interpreter\Validation\Check;

use App\Interpreter\Compare;

class CompareTest extends \Test\Interpreter\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->valueobject_simple();
        $factory = $this->app->make(Compare\Factory::class);
        $this->interpreter = $factory->ast($ast->check->condition[0]);
    }
    
    public function test_pass()
    {
        $this->assertTrue($this->interpreter->check(1));
    }
    
    public function test_fail()
    {
        $this->assertFalse( $this->interpreter->check(-1) );
    }
}
