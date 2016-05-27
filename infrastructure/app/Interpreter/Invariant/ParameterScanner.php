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
            $properties[] = $this->get_properties($where);
        }
        return array_filter($properties);
    }
    
    private function scan_check($ast)
    {
        $properties = [];
        foreach ($ast->condition as $condition) {
            $properties[] = $this->get_properties($condition);
        }
        return array_filter($properties);
    }
    
    private function get_properties($condition) 
    {
        $value = $condition->value;
        if (isset($value->property)) {
            return $value->property[0];
        }
        return;
    }
}



