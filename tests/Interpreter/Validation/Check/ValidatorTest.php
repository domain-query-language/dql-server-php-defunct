<?php namespace Test\Interpreter\Validation\Check;

use App\Interpreter\Validation\Validator;

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
        $this->assertTrue($this->interpreter->check('0fabce80-7364-45ae-aadd-04e3df412e58'));
    }
    
    public function test_fail()
    {
        $this->assertFalse($this->interpreter->check('afddfdd'));
    }
}
