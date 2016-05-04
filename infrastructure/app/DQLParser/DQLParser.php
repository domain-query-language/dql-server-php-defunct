<?php namespace Infrastructure\App\DQLParser;

use App\DQLParser\ParserError;

class DQLParser implements \App\DQLParser\DQLParser
{
    private $schema_path; 
    private $parser_path;
    
    public function __construct()
    {
        $this->schema_path = base_path("infrastructure/app/DQLParser/PegJSGrammar.pegjs");
        $this->parser_path = base_path("infrastructure/app/DQLParser/PHPPegJSParser.php");
        $this->parser_generator_script = base_path("infrastructure/app/DQLParser/GenerateParser.js");
    }
    
    public function parse($dql_statement) 
    {
        $parser = $this->fetch_parser();
        try {
            return $this->array_tree_to_object_tree($parser->parse($dql_statement));
        } catch (SyntaxError $ex) {
            $message = "Syntax error: " . $ex->getMessage() . ' At line ' . $ex->grammarLine . ' column ' . $ex->grammarColumn . ' offset ' . $ex->grammarOffset;
            throw new ParserError($message);
        }
    }
    
    private function array_tree_to_object_tree($array)
    {
        return json_decode(json_encode($array));
    }
    
    private function fetch_parser()
    {
        if (app()->environment() != "production") {
            return $this->develop_parser();
        } else {
            return $this->make_parser();
        }
    }
    
    private function develop_parser()
    {
        if ($this->has_parser_schema_been_updated()) {
            $this->create_parser_file_from_schema();
        } else {
            return $this->make_parser();
        }
    }
    
    private function has_parser_schema_been_updated()
    {
        if (!file_exists($this->parser_path)) {
            return true;
        } 
        if (!file_get_contents($this->parser_path)) {
            return true;
        }
        $schema_last_update = filemtime($this->schema_path);
        $parser_last_update = filemtime($this->parser_path);
        
        if ($schema_last_update > $parser_last_update) {
            return true;
        }
        return false;
    }
    
    private function create_parser_file_from_schema()
    {
        $parser_code = [];
        exec("/usr/bin/node ".$this->parser_generator_script, $parser_code);
        file_put_contents($this->parser_path, implode("\n", $parser_code));
    }
    
    private function make_parser()
    {
        return new PHPPegJSParser();
    }
}