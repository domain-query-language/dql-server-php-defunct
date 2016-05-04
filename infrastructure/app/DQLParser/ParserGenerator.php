<?php namespace Infrastructure\App\DQLParser;

class ParserGenerator
{
    public function generate($grammar, $namespace, $class_name)
    {
        $generated_code = $this->call_generation_script($grammar);
            
        //Change the namespace
        $generated_code = str_replace(
            "namespace PhpPegJs;", 
            "namespace ".$namespace.";", 
            $generated_code
        );
        $generated_code = str_replace(
            "if (!function_exists('PhpPegJs", 
            "if (!function_exists('".$namespace, 
            $generated_code
        );
        
        //Change the class
        $generated_code = str_replace(
            "class Parser{",
            "class ".$class_name."{", 
            $generated_code
        );
        
        return $generated_code;
    }
    
    private function call_generation_script($grammar)
    {
        $this->assert_has_node();
        
        $path_to_grammar = tempnam(null, null);
        file_put_contents($path_to_grammar, $grammar);
        
        $parser_generator_script = base_path("infrastructure/app/DQLParser/GenerateParser.js");
        
        $result_array = [];
        $return_var = 0;
                
        exec("node $parser_generator_script $path_to_grammar", $result_array, $return_var);
                
        $result_message = implode("\n", $result_array);
        
        if ($return_var == 1) {
            throw new \Exception($result_message);
        }
        
        if (!$result_message) {
            throw new \Exception("Error generating parser script. Please ensure nodejs is installed.");
        }
                
        return $result_message;
    }
    
    private function assert_has_node()
    {
        $returnVal = shell_exec("which node");
        if (empty($returnVal)) {
            throw new \Exception("NodeJS is not installed. Please update your system.");
        }
    }
}