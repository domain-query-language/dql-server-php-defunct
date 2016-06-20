<?php namespace Test\Interpreter\Handler\Handler\Assert;

use App\Interpreter\Handler\Assert;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $apply_factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $this->apply_factory = $this->app->make(Assert\Factory::class);
        $ast = $this->fake_ast_repo->assert();
        $this->interpreter = $this->apply_factory->ast($ast);     
    }
    
    public function test_pass()
    {        
        $root = (object)['is_created'=>false];
        
        $this->interpreter->interpret($root, null);
    }
    
    public function test_fail()
    {
        $root = (object)['is_created'=>true];
        
        $this->setExpectedException(\App\Interpreter\Handler\Invariant\Exception::class);
        
        $this->interpreter->interpret($root, null);
    }  
}
