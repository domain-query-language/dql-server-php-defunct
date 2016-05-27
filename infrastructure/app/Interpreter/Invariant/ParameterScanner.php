<?php namespace Infrastructure\App\Interpreter\Invariant;

class ParameterScanner
{        
    public function scan($ast)
    { 
        if ($ast->query) {
            return $this->scan_query($ast->query);
        } 
        return $this->scan_check($ast->check);
    }
    
    private function scan_query($ast)
    {
        $properties = [];
        foreach ($ast->where as $where) {
            $properties = $this->get_properties($where);
        }
        return $properties;
    }
    
    private function scan_check($ast)
    {
        return $this->get_properties($ast->condition);
    }
    
    private function get_properties($condition) 
    {
        $value = $condition->value;
        if (isset($value->property)) {
            return $value->property;
        }
        return [];
    }
}



