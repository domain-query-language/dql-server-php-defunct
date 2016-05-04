<?php

use App\DQLParser;

class DQLParserTest extends TestCase
{    
    /**
     * @var DQLParser 
     */
    protected $parser;
    
    public function setUp()
    {
        $this->parser = $this->createApplication()->make(DQLParser\DQLParser::class);
    }
    
    public function test_parse_create_environment()
    {
        $dql_statement = "create environment 'test';";
        $ast = json_decode('{
            "type": "command",
            "name": "CreateEnvironment",
            "value": "test"
        }');
                
        $this->assertEquals($ast, $this->parser->parse($dql_statement));
    }
    
    public function test_parse_failure()
    {
        $dql_statement = "create bleh";
        $this->expectException(DQLParser\ParserError::class);
        $this->parser->parse($dql_statement);
    }
}


