<?php namespace App\Interpreter\Query;

class SQLFactory
{
    public function ast($ast)
    {
        return $this->select_statement($ast->query->select)
                ." ".$this->from_statement($ast->aggregate_id)
                ." ".$this->where_statement($ast->query->where); 
    }
    
    private function select_statement($ast)
    {
        $select = [];
        foreach ($ast as $select_ast) {
            $select[] = $this->select($select_ast);
        }
        return "SELECT ".implode(", ", $select);
    }
    
    private function select($ast)
    {
        $select = "$ast->field";
        if ($ast->operation) {
            $select = strtoupper($ast->operation)."($select)";
        }
        
        if ($ast->alias) {
            $select = "$select AS $ast->alias";
        }
        return "$select";
    }
    
    private function from_statement($aggregate_id)
    {
        return "FROM aggregate_".str_replace("-", "_", $aggregate_id);
    }
    
    private function where_statement($ast)
    {
        $wheres = [];
        foreach ($ast as $where_ast) {
            $wheres[] = $this->where($where_ast);
        }
        return "WHERE ".implode(" AND ", $wheres);
    }
    
    private function where($ast)
    {
        $comparator = ($ast->comparator == "==") ? "=" : $ast->comparator;
        
        return "$ast->field $comparator?";
    }
}
