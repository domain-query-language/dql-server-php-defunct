<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\ValueObject;

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
