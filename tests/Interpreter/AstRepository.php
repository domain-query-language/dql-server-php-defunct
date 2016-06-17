<?php namespace Test\Interpreter;

use App\Interpreter\Validation;
use App\Interpreter\Modification;
use App\Interpreter\Handler;
use App\Interpreter\Query;
use App\Interpreter\Command;

class AstRepository implements 
        Validation\AstRepository, 
        Modification\AstRepository, 
        Handler\AstRepository, 
        Query\AstRepository,
        Command\AstRepository
{
    private static $asts = [];
    
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
    
    protected function preload_asts()
    {
        $ast_path = 'tests/Interpreter/asts';
        $folder_path = base_path($ast_path);

        $asts = array_diff(scandir($folder_path), array('..', '.'));

        foreach ($asts as $ast_file) {
            $ast = $this->load_ast(str_replace(".json", "", $ast_file));
            if (isset($ast->id)) {
                self::$asts[$ast->id] = $ast;
            }
        }
    }
    
    public function fetch($id)
    {
        if (count(self::$asts) == 0) {
            $this->preload_asts();
        }
        return self::$asts[$id];
    }

    public function store($ast)
    {
        //Not used
    }
}

