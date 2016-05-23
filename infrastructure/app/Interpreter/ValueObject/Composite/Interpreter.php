<?php namespace Infrastructure\App\Interpreter\ValueObject\Composite;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $keys;
    private $interpreters;
    
    public function __construct($interpreters, $keys)
    {
        $this->keys = $keys;
        $this->interpreters = $interpreters;
    }
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $result = new \stdClass();
        foreach ($this->keys as $index=>$key) {
            $value_context = $context->set_property('value', $context->get_property($key));
            $result->$key = $this->interpreters[$index]->interpret($value_context);
        }
        return $result;
    }
}

