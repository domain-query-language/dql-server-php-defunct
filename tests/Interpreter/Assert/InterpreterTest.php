<?php namespace Test\Interpreter\Assert;

use Infrastructure\App\Interpreter\Assert;
use App\Interpreter\Context;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $apply_factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $this->apply_factory = $this->app->make(Assert\Factory::class);
        $ast = $this->ast_repo->assert();
        $this->interpreter = $this->apply_factory->ast($ast);     
    }
    
    public function test_pass()
    {        
        $context = new Context(['is_created'=>false]);
        
        $this->interpreter->interpret($context);
    }
    
    public function test_fail()
    {
        $context = new Context(['is_created'=>true]);
        
        $this->setExpectedException(\App\Interpreter\InvariantException::class);
        
        $this->interpreter->interpret($context);
    }  
}
