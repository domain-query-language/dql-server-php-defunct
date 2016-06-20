<?php namespace Test\Interpreter\Validation\Check;

use App\Interpreter\Validation\Compare;

class CompareTest extends \Test\Interpreter\TestCase
{
    private $factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $ast = $this->fake_ast_repo->valueobject_simple();
        $this->factory = $this->app->make(Compare\Factory::class);
        $this->interpreter = $this->factory->ast($ast->check->condition[0]);
    }
    
    public function test_pass()
    {
        $this->assertTrue($this->interpreter->check(1));
    }
    
    public function test_fail()
    {
        $this->assertFalse( $this->interpreter->check(-1) );
    }
    
    public function test_handles_properties()
    {
        $ast = $this->fake_ast_repo->invariant();
        $this->factory = $this->app->make(Compare\Factory::class);
        $this->interpreter = $this->factory->ast($ast->check->condition[0]);
        
        $this->assertFalse($this->interpreter->check((object)['is_created'=>false]));
    }
}
