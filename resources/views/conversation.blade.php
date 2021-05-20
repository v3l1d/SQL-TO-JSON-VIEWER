<!DOCTYPE html>
@extends('welcome')

<title>Conversation editor</title>
<head>
<link rel="stylesheet" href="./js/conversation.css">

<!-- navbar -->
<ul>
<li><a class="active" href="#home">SA-SW</a></li>
<button class="sfondo-bottone" id="save">Salva</button>
<button class="sfondo-bottone" id="open">Apri</button>
<button class="sfondo-bottone" id="export">Esporta</button>
</ul>



</head>

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
    /*for(var i in dataFromCall){

      $("body").append("<br> <div class=\"dropdown\" id=\""+dataFromCall[i].name+"\">"+dataFromCall[i].name+"<div id=\"dropdown-content\"><p></p></div></div></br>");
      for(var j in dataFromCall[i].columns){
       //   $("mySidebar").append("<br>"+dataFromCall[i].columns[j].name+"</br>")

      }

    }*/
    for (var i in dataFromCall){
    $("#mySidebar").append("<br><div class=\"dropdown\" \"><button onclick=\"myFunction()\"class=\"dropbtn\" id=\""+dataFromCall[i].name+"\">"
    +dataFromCall[i].name+"</button><div id=\"mydropdown\" class=\"dropdown-content\"></div></div><br><hr>")
  }


      var extractData;
      $("#mySidebar").on("click",function(event){
        var id=event.target.id;

        for( var i in dataFromCall){
          if(dataFromCall[i].name===id){
            extractData=dataFromCall[i];
          }
        }

      });

      console.log(extractData);
  });



  </script>

</body>
