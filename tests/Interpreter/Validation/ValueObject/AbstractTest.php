<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\Validation\ValueObject;

abstract class AbstractTest extends \Test\Interpreter\TestCase
{
    protected $interpreter;
    
    abstract protected function ast();
    
    public function setUp()
    {
        parent::setUp();
        $factory = $this->app->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($this->ast());
    }
}
