
var pegjs = require("pegjs");
var phppegjs = require("php-pegjs");
var fs = require('fs');
var str = require('string');

fs.readFile("/home/vagrant/dql-server/Infrastructure/App/DQLParser/PegJSGrammar.pegjs", 'utf8', function (err, schema) {
  
  if (err) {
    return console.log(err);
  }

  var parserNamespace = "Infrastructure\\App\\DQLParser";
	var parserClassName = "PHPPegJSParser";

	var parser = pegjs.buildParser(schema, {
    plugins: [phppegjs]
	});
  
  //Change the namespace
  parser = str(parser).replaceAll("namespace PhpPegJs;", "namespace "+parserNamespace+";");
  
  parserNamespace = "Infrastructure\\\\App\\\\DQLParser";
  parser = str(parser).replaceAll("if (!function_exists('PhpPegJs", "if (!function_exists('"+parserNamespace);
  
  //Change the class
  parser = str(parser).replaceAll("class Parser{", "class "+parserClassName+"{");
  
	console.log(parser.s);
});
