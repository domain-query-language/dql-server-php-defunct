<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;
use Infrastructure\App\Interpreter\Compare;
use App\Interpreter\ValueObjectRepository as VoRepo;

class CompositeTest extends \Test\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/ValueObject/composite-ast.json');
        $this->app()->bind(VoRepo::class, ValueObjectRepository::class);
        $factory = $this->app()->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($ast);
    }
    
    public function test_build()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');
        $context = $context->set_property('max', '5');

        $value = $this->interpreter->interpret($context);
        
        $expected = ['min'=>1, 'max'=>5];
        
        $this->assertEquals((object)$expected, $value);
    }
    
    public function test_fail_if_value_wrong()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');
        $context = $context->set_property('max', 'dasdasDdaSDasd');

        $this->setExpectedException(Compare\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
    
    public function test_fails_if_key_missing()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');

        $this->setExpectedException(\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
