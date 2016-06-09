<?php namespace Test\Interpreter\Validation\Check;

use App\Interpreter\Context;
use App\Interpreter\Validator;

class ValidatorTest extends \Test\Interpreter\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->valueobject_validator();
        
        $factory = $this->app->make(Validator\Factory::class);
        $this->interpreter = $factory->ast($ast->check->condition[0]);
    }
    
    public function test_build()
    {
        $context = new Context(['value'=>'0fabce80-7364-45ae-aadd-04e3df412e58']);
        
        $this->assertTrue($this->interpreter->interpret($context));
    }
    
    public function test_fail()
    {
        $context = new Context(['value'=>'asdfsadsdf']);
        
        $this->assertFalse($this->interpreter->interpret($context));
    }
}
