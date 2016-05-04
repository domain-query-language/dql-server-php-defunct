<?php

use Infrastructure\App\DQLParser\PHPPegJS\ParserGenerator;

class PegJSParserGeneratorTest extends TestCase
{    
    /**
     * @var ParserGenerator 
     */
    private $parser_generator;
    private $parser_namespace;
    private $parser_class_name;
    
    public function setUp()
    {
        $this->parser_generator = new ParserGenerator();
        $this->parser_namespace = "ParseGeneratorTest";
        $this->parser_class_name = "Parse".rand(0, 10000000000);
    }
    
    public function test_valid_grammar()
    {
        $grammar = '
            Name = name:[A-Za-z0-9_-]+
                {
                    return ["name"=>join("", $name)];
                }';
                
        $full_class_path = "$this->parser_namespace\\$this->parser_class_name";
        
        $generated_parser_code = $this->parser_generator->generate(
            $grammar, 
            $this->parser_namespace, 
            $this->parser_class_name
        );
        
        $temp_parser_class_file = tempnam(null, null);
        file_put_contents($temp_parser_class_file, $generated_parser_code);
                
        require("$temp_parser_class_file");

        $parser = new $full_class_path();
        
        $ast = $parser->parse("Tim");
     
        $this->assertEquals(['name'=>'Tim'], $ast);
    }
    
    public function test_bad_grammar()
    {
        $this->setExpectedException(\Exception::class);
        
        $grammar = "dfasd gdsndgomb sG fah";
        
        $this->parser_generator->generate(
            $grammar, 
            $this->parser_namespace, 
            $this->parser_class_name
        );
    }
}


