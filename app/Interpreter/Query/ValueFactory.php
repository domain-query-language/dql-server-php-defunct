<?php namespace App\Interpreter\Query;

use App\Interpreter\Context;

class ValueFactory
{
    private $properties;
    
    public function __construct($ast)
    {
        $this->properties = array_map(function($where){
            return $where->value->property;
        }, $ast);
    }
    
    public function context(Context $context)
    {
        return array_map(function($property) use ($context) {
            return $context->get_property($property);
        }, $this->properties);
    }
}
