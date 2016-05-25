<?php namespace Test\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\ValueObject;
use App\Interpreter\ValueObjectRepository as VoRepo;

abstract class AbstractTest extends \Test\Interpreter\TestCase
{
    protected $interpreter;
    
    abstract protected function ast();
    
    public function setUp()
    {
        parent::setUp();
        $this->app()->bind(VoRepo::class, ValueObjectRepository::class);
        $factory = $this->app()->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($this->ast());
    }
}
