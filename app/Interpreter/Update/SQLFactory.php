<?php namespace App\Interpreter\Update;

class SQLFactory
{
    public function ast($ast)
    {
        return $this->update_statement($ast->aggregate_id)
                ." ".$this->set_statement($ast->statements);
    }
        
    private function update_statement($aggregate_id)
    {
        return "UPDATE aggregate_".str_replace("-", "_", $aggregate_id);
    }
    
    private function set_statement($ast)
    {
        $set = [];
        foreach ($ast as $statement_ast) {
            $set[] = $this->set($statement_ast);
        }
        return "SET ".implode(", ", $set);
    }
    
    private function set($ast)
    {
        return "$ast->property =?";
    }
}
