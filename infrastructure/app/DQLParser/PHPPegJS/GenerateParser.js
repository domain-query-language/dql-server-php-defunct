
var pegjs = require("pegjs");
var phppegjs = require("php-pegjs");
var fs = require('fs');
var str = require('string');

var grammarFile = process.argv[2];

fs.readFile(grammarFile, 'utf8', function (err, schema) {
  
  if (err) {
    return console.log(err);
  }

  try {
    var parser = pegjs.buildParser(schema, {
      plugins: [phppegjs]
    });
  } catch(e){
    console.log(e.message);
    process.exit(1);
    return;
  }
  
	console.log(parser);  
});
