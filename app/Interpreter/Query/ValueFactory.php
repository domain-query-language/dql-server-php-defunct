<?php namespace App\Interpreter\Query;

class ValueFactory
{
    private $properties;
    
    public function __construct($ast)
    {
        $this->properties = array_map(function($where){
            return $where->value->property;
        }, $ast);
    }
    
    public function context($context)
    {
        return array_map(function($properties) use ($context) {
            if (is_string($properties)) {
                $properties = [$properties];
            }

            $node = $context;
            foreach ($properties as $property) {
                $node = $node->$property;
            }
            return $node;
        }, $this->properties);
    }
}
