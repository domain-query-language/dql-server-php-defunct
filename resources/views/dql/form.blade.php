<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript">

$(function(){
    
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
    
    $("#submit").click(function(){
        var data = {
            statement: $("#statement").val()
        };
       $.post("/dql/command", data).then(processResponse);
    });
   
    function processResponse(data)
    {
       
    }
});


</script>
</head>
<body>
<h3>Enter DQL Statement</h3>
<form action="/dql/command" method="post">
  <textarea style="width:50%;height:100px;" id="statement"></textarea><br>
  <button id="submit" type="button">Submit</button>
</form>
</body>    
</html>