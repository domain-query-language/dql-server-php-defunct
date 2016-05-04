<html>
<head>
  <style type="text/css">
    
    body {
      font-family: arial;
    }
    
  </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript">

$(function(){
    
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
    
    var statement = "";
    
    $("#submit").click(function(){
        
        statement = $("#statement").val();
        
        var data = {
            statement: $("#statement").val()
        };
       $.post("/dql/command", data).then(success, failure);
    });
   
    function success(data)
    {
       $("#result").html("<div>"+data+"</div>");    
       $("#statement").val("");
    }
    
    function failure()
    {
        $("#result").html("<pre style='color:red'>Failure</pre>");
    }
    
});


</script>
</head>
<body>
<h3>Enter DQL Statement</h3>
<div style="width:50%; float:left;">
    <form action="/dql/command" method="post">
      <textarea style="width:90%;height:100px;" id="statement"></textarea><br>
      <button id="submit" type="button">Submit</button>
    </form>
</div>
<div style="width:50%; float:left;">
    <b>Response</b>
    <div id="result"></div>
</div>
</body>    
</html>