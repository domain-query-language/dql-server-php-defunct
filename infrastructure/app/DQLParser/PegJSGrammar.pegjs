
Command = CreateEnvironment / UsingEnvironment

CreateEnvironment = _ "create" _ "environment" _ value:QuotedName _ ";"
  {
    return [
      'type' => 'command',
      'name' => 'CreateEnvironment',
      'value' => $value
    ];
  }

UsingEnvironment = _ "using" _ "environment" _ value:QuotedName _ ";"
  {
    return [
      'type' => 'command',
      'name' => 'UsingEnvironment',
      'value' => $value
    ];
  }

QuotedName = SingleQuotedName / DoubleQuotedName

SingleQuotedName = "'" name:Name "'"
  {
    return $name;
  }

DoubleQuotedName = "\"" name:Name "\""
  {
    return $name;
  }

Name = name:[A-Za-z0-9_-]+
  {
    return join("", $name);
  }

_ = [ \t\n\r]*