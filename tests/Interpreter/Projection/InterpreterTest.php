<?php namespace Test\Interpreter\Projection;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Update;
use Infrastructure\App\Interpreter\Invariant;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\TestCase
{
    protected $context;

    public function setUp()
    {
        $this->context = new Context();
        $this->context->set_property('shopper_id', '5d37e24a-f833-45f3-90b1-3ac70fd05ac4');

        $this->app()->bind(\PDO::class, MockPDO::class);
    }
    
    public function test_query_returns_false_initially()
    {
        $result = $this->query_interpreter()->interpret($this->context);
        $this->assertFalse($result);
    }
    
    private function query_interpreter()
    {
        $ast = $this->load_json('tests/Interpreter/Projection/invariant-ast.json');
        $invariant_factory = $this->app()->make(Invariant\Factory::class);
        return $invariant_factory->ast($ast);
    }
    
    public function test_update_sets_the_value()
    {
        $this->update_interpreter()->interpret($this->context);
        
        $result = $this->query_interpreter()->interpret($this->context);
        $this->assertTrue($result);
    }
    
    private function update_interpreter()
    {
        $ast = $this->load_json('tests/Interpreter/Projection/event-handler-ast.json');
        $query_factory = $this->app()->make(Update\Factory::class);
        return $query_factory->ast($ast);
    }
    
    public function test_query_returns_false_for_different_shopper_id()
    {
        $query_context = new Context();
        $query_context->set_property('shopper_id', 'c6955003-814c-4f55-b907-006d7563579b');
        
        $result = $this->query_interpreter()->interpret($query_context);
        $this->assertFalse($result);
    }  
}
