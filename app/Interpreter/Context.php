<?php namespace App\Interpreter;

/**
 * Stub invariant for testing purposes
 */
class Context
{
    private $data;
    
    public function __construct($data = null)
    {
        if (is_null($data)) {
            $data = new \stdClass();
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
            return $this->get_key($this->data, $ast);
        }
        
        if (count($ast) == 0) {
            throw new \Exception("Invalid property count, cannot find blank property.");
        }
        $property = $this->data;
        foreach ($ast as $key) {
            $property = $this->get_key($property, $key);
        }
        return $property;
    }
    
    private function get_key($object, $key)
    {
        if (!isset($object->$key)) {
            throw new \Exception("Property '$key' does not exist"); 
        }
        return $object->$key;
    }
}

