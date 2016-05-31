<?php namespace Test;

require_once 'CommandLine/Valid.php';
require_once 'CommandLine/Invalid.php';

class PegJSParserGeneratorTest extends TestCase
{    
    private $parser_namespace;
    private $parser_class_name;
    
    public function setUp()
    {
        parent::setUp();
        $this->parser_namespace = "ParseGeneratorTest";
        $this->parser_class_name = "Parse".rand(0, 10000000000);
    }
     
    public function test_valid()
    {       
        $generator = new \Infrastructure\App\DQLParser\PHPPegJS\ParserGenerator(new \Valid());
        
        $generated_code = $generator->generate(
            'test string', 
            $this->parser_namespace, 
            $this->parser_class_name
        );
        
        $this->assertTrue(str_contains($generated_code, "namespace $this->parser_namespace"));
        $this->assertTrue(str_contains($generated_code, "class $this->parser_class_name"));
    }
    
    public function test_bad_grammar()
    {
        $this->setExpectedException(\Exception::class, "ERROR");
        
        $generator = new \Infrastructure\App\DQLParser\PHPPegJS\ParserGenerator(new \Invalid());
                
        $generator->generate(
            'test string', 
            $this->parser_namespace, 
            $this->parser_class_name
        );
    }
}


