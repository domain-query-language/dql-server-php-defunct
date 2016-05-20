<?php namespace Test\Interpreter\Projection;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Update;
use Infrastructure\App\Interpreter\Query;

class InterpreterTest extends \Test\TestCase
{
    protected $query_context;
    protected $update_context;
    
    public function setUp()
    {
        $query = new \stdClass();
        $query->shopper_id = '5d37e24a-f833-45f3-90b1-3ac70fd05ac4';
        
        $this->query_context = new Context();
        $this->query_context->set_property('query', $query);
        
        $this->update_context = new Context();
        $this->query_context->set_property('update', $query);        
    }
    
    public function test_query_returns_false_initially()
    {
        $result = $this->query_interpreter()->interpret($this->query_context);
        $this->assertFalse($result);
    }
    
    private function query_interpreter()
    {
        $ast = $this->load_json('tests/Interpreter/Projection/invariant-ast.json');
        $query_factory = $this->app()->make(Query\Factory::class);
        return $query_factory->ast($ast);
    }
    
    public function test_update_sets_the_value()
    {
        $this->update_interpreter()->interpret($this->update_context);
        
        $result = $this->query_interpreter()->interpret($this->query_context);
        $this->assertTrue($result);
    }
    
    private function update_interpreter()
    {
        $ast = $this->load_json('tests/Interpreter/Projection/handler-ast.json');
        $query_factory = $this->app()->make(Update\Factory::class);
        return $query_factory->ast($ast);
    }
    
    public function test_query_returns_false_for_different_shopper_id()
    {
        $query = new \stdClass();
        $query->shopper_id = 'c6955003-814c-4f55-b907-006d7563579b';
        
        $query_context = new Context();
        $query_context->set_property('query', $query);
        
        $result = $this->query_interpreter()->interpret($this->query_context);
        $this->assertFalse($result);
    }  
}
