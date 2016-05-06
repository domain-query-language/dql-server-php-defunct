<?php namespace Infrastructure\App\DQLParser\PHPPegJS;

class ParserGenerator
{
    private $command_line;
    
    public function __construct(CommandLine $command_line)
    {
        $this->command_line = $command_line;
    }
    
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
        $path_to_grammar = tempnam(null, null);
        file_put_contents($path_to_grammar, $grammar);
                
        $result_array = [];
        $return_var = 0;
                
        $this->command_line->execute(
            "node node_modules/peg-php-parser-generator/script/generate.js $path_to_grammar", 
            $result_array, 
            $return_var
        );
                
        $result_message = implode("\n", $result_array);

        if ($return_var == 1) {
            throw new \Exception($result_message);
        }
        
        if (!$result_message) {
            throw new \Exception("Error generating parser script. Please ensure nodejs is installed.");
        }
                
        return $result_message;
    }
}