<?php namespace Test\Interpreter;

class AstRepository
{
    public function __call($name, $arguments)
    {
        return $this->load_ast($name);
    } 
    
    protected function load_ast($ast_file)
    {
        $file_path = 'tests/Interpreter/asts/'.$ast_file.".json";
        $full_file_path = base_path($file_path);
        if (!is_file($full_file_path)) {
            throw new \Exception("Cannot find AST '$ast_file'");
        }
        return json_decode(file_get_contents($full_file_path));
    }
}

