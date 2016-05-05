<html>
<head>
  <style type="text/css">
    
    body {
      font-family: arial;
    }
    
    textarea {
      font-size: 14px;
      padding: 5px;
      line-height: 150%;
    }
    
    #statement_log {
      color: #888;
      font-size: 12px;
    }
    
    #statement_log div {
      border-left: 1px solid #aaa;
      margin: 5px;
      padding-left: 10px;
    }
    
  </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript">

$(function(){
    
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
        
    $("#submit").click(function(){
        
        var data = {
            statement: $("#statement").val()
        };
       $.post("/dql/command", data).then(success, failure);
    });
   
    function success(data)
    {
       $("#result").html("<div>"+data+"</div>");   
       $("#statement_log").append("<div>"+$("#statement").val()+"</div>");
       $("#statement").val("");
    }
    
    function failure(jqxhr)
    {
        $("#result").html("<div style='color:red'>Failure</div>")
          .append("<div>"+jqxhr.responseText+"</div>");
    }
    
});


</script>
</head>
<body>
<h3>Enter DQL Statement</h3>
<div style="width:50%; float:left;">
  <div style="margin-right: 20px;">
    <form action="/dql/command" method="post">
      <textarea style="width:100%;height:100px;" id="statement"></textarea><br>
      <button style="float:right" id="submit" type="button">Submit</button>
      <div style="clear:both"></div>
    </form>
    <b>Successful commands:</b>
    <div id="statement_log">
    </div>
  </div>
</div>
<div style="width:50%; float:left;">
    <b>Response:</b>
    <div id="result"></div>
</div>
</body>    
</html>