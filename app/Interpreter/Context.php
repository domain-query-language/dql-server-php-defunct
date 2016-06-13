<?php namespace App\Interpreter;

class Context
{
    private $data;
    
    public function __construct($data = null)
    {
        if (is_array($data)) {
            $data = (object)$data;
        }
        if (is_null($data)) {
            $data = new \stdClass();
        }
        if (!isset($data->root)) {
            $data->root = new \stdClass();
        }
        $this->data = $data;
    }
    
    public function set_property($property, $value)
    {
        $data = $this->data;
        $data->$property = $value;
        return new Context($data);
    }
    
    public function get_property($ast)
    {
        if (is_string($ast)) {
            $ast = [$ast];
        }
        
        if (count($ast) == 0) {
            throw new \Exception("Invalid property count, cannot find blank property.");
        }
        
        $root = $ast[0];
        if (!isset($this->data->$root)) {
            array_unshift($ast, 'root');
        }
        
        $property = $this->data;
        foreach ($ast as $key) {
            $property = $this->get_key($property, $key);
        }
        return $property;
    }
    
    public function has_property($key)
    {
        return isset($this->data->$key);
    }
    
    private function get_key($object, $key)
    {
        if (!isset($object->$key)) {
            throw new Context\PropertyException("Property '$key' does not exist"); 
        }
        return $object->$key;
    }
}

