<?php namespace Infrastructure\App\DQLParser\PHPPegJS;

use App\DQLParser\ParserError;

class DQLParser implements \App\DQLParser\DQLParser
{
    private $schema_path; 
    private $parser_path;
    private $parser_class_name = "PHPPegJSParser";
    
    public function __construct()
    {
        $this->schema_path = base_path("infrastructure/app/DQLParser/PHPPegJS/PegJSGrammar.pegjs");
        $this->parser_path = base_path("infrastructure/app/DQLParser/PHPPegJS/$this->parser_class_name.php");
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
        $is_not_production = app()->environment() != "production";
        if ($is_not_production && $this->has_parser_schema_been_updated()){
            $this->generate_parser();
        }
        return $this->make_parser();
    }
    
    private function generate_parser()
    {
        $parser_code = $this->create_parser_code_from_schema();
        $this->store_parser_code($parser_code);
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
    
    private function create_parser_code_from_schema()
    {
        $parser_generator = new ParserGenerator();
        return $parser_generator->generate(
            file_get_contents($this->schema_path),
            "Infrastructure\\App\\DQLParser\\PHPPegJS" ,
            $this->parser_class_name
        );
    }
    
    private function store_parser_code($parser_code)
    {
        file_put_contents($this->parser_path, $parser_code);
    }
    
    private function make_parser()
    {
        return new PHPPegJSParser();
    }
}