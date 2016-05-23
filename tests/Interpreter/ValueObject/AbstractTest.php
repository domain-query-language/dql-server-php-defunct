<?php namespace Test\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\ValueObject;
use App\Interpreter\ValueObjectRepository as VoRepo;

abstract class AbstractTest extends \Test\TestCase
{
    protected $interpreter;
    
    abstract protected function ast_file_path();
    
    public function setUp()
    {
        $ast = $this->load_json( $this->ast_file_path());
        $this->app()->bind(VoRepo::class, ValueObjectRepository::class);
        $factory = $this->app()->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($ast);
    }
}
