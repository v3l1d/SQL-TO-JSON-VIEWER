<!DOCTYPE html>
@extends('welcome')

<title>conversation editor</title>
<head>
<link rel="stylesheet" href="./js/conversation.css"></head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<body>
  <div class="w3-sidebar w3-light-grey w3-bar-block" id="mySidebar" style="width:15%">

</div>

  <script type="text/javascript">
  var dataFromCall;
  $.ajax({
    method:'GET',
    url:'http://localhost:3000',
    async:false,
    success:function(data){
      dataFromCall=data;
    }

  });

  $(document).ready(function(){
    console.log(dataFromCall);
    for(var i in dataFromCall){
      $("#mySidebar").html("<br><p>"+dataFromCall[i].name+"</p><br><hr>");
    }
  });

  </script>

</body>
