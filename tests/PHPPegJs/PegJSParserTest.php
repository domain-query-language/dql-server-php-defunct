<?php

class PegJSParserTest extends DQLParserTest
{    
    public function test_rebuild_on_schema_update()
    {
        touch(base_path("infrastructure/app/DQLParser/PHPPegJS/PegJSGrammar.pegjs"));
        
        $dql_statement = "create environment 'test';";
        $ast = json_decode('{
            "type": "command",
            "name": "CreateEnvironment",
            "value": "test"
        }');
                
        $this->assertEquals($ast, $this->parser->parse($dql_statement));
        
        touch(base_path("infrastructure/app/DQLParser/PegJSGrammar.pegjs"));
    } 
}


