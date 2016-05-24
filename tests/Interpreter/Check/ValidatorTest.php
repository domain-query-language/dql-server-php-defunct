<?php namespace Test\Interpreter\Check;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Validator;

class ValidatorTest extends \Test\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/Check/validator-ast.json');
        $factory = $this->app()->make(Validator\Factory::class);
        $this->interpreter = $factory->ast($ast->condition);
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
