<?php namespace Test\Interpreter\Check;

use Infrastructure\App\Interpreter\Check;

class CheckTest extends \Test\TestCase
{   
    public function test_check_factory_handles_compare_ast()
    {
        $ast = $this->load_json('tests/Interpreter/asts/valueobject-simple.json');
        $factory = $this->app()->make(Check\Factory::class);
        
        $this->assertInstanceOf(Check\Interpreter::class, $factory->ast($ast->check));
    }
    
    public function test_check_factory_handles_validator_ast()
    {
        $ast = $this->load_json('tests/Interpreter/asts/valueobject-validator.json');
        $factory = $this->app()->make(Check\Factory::class);
        
        $this->assertInstanceOf(Check\Interpreter::class, $factory->ast($ast->check));
    }
}
