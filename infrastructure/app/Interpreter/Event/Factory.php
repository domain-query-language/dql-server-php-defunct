<?php namespace Infrastructure\App\Interpreter\Event;

use Infrastructure\App\Interpreter\ValueObject;

class Factory
{    
    private $valueobject_factory;
    
    public function __construct(ValueObject\Factory $valueobject_factory)
    {
        $this->valueobject_factory = $valueobject_factory;
    }
    
    public function ast($ast)
    {
        $payload_interpreter = $this->valueobject_factory->ast($ast);
        return new Interpreter($ast->id, $payload_interpreter);
    }
}

