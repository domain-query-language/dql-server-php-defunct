<?php namespace Test\Interpreter\Projection;

use App\Interpreter\Update;
use App\Interpreter\Handler\Invariant;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    protected $root;

    public function setUp()
    {
        parent::setUp();
        $this->root = (object)[
            'shopper_id' => '5d37e24a-f833-45f3-90b1-3ac70fd05ac4',
            'is_created' => true
        ];

        $this->app->bind(\PDO::class, MockPDO::class);
    }
    
    public function test_query_returns_false_initially()
    {
        $result = $this->invariant_interpreter()->check($this->root);
        $this->assertFalse($result);
    }
    
    private function invariant_interpreter()
    {
        $ast = $this->fake_ast_repo->invariant_projection();
        $invariant_factory = $this->app->make(Invariant\Factory::class);
        return $invariant_factory->ast($ast);
    }
    
    public function test_update_sets_the_value()
    {
        $this->update_interpreter()->update($this->root);
        
        $result = $this->invariant_interpreter()->check($this->root);
        $this->assertTrue($result);
    }
    
    private function update_interpreter()
    {
        $ast = $this->fake_ast_repo->event_handler();
        $update_factory = $this->app->make(Update\Factory::class);
        return $update_factory->ast($ast);
    }
    
    public function test_query_returns_false_for_different_shopper_id()
    {
        $this->root->shopper_id = 'c6955003-814c-4f55-b907-006d7563579b';
        
        $result = $this->invariant_interpreter()->check($this->root);
        $this->assertFalse($result);
    }  
}
