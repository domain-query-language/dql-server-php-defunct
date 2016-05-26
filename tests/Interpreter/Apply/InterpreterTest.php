<?php namespace Test\Interpreter\Apply;

use Infrastructure\App\Interpreter\Apply;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $apply_factory = $this->app()->make(Apply\Factory::class);
        $ast = $this->ast_repo->apply();
        //$this->interpreter = $apply_factory->ast($ast);     
    }
    
    public function test_creates_event()
    {
        
    }
    
    public function test_creates_event_with_arguments()
    {
        
    }
}
