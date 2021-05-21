<!DOCTYPE html>
@extends('welcome')

<title>Conversation Editor</title>
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
  <h3 id="testo_sidebar"> ▶ Database Overview</h3>
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
      $("#mySidebar").append("<br><div class=\"dropdown\" \"><button class=\"dropbtn\" id=\""+dataFromCall[i].name+"\">"
    +dataFromCall[i].name+"</button><div class=\"dropdown-content\" id=\""+dataFromCall[i].name + "_content" +"\"></div></div><br><hr>")
    $("#"+dataFromCall[i].name+"_content").hide();
    for(var j in dataFromCall[i].columns){
    $("#"+dataFromCall[i].name+"_content").append(dataFromCall[i].columns[j].name + "<br>");
    } 
  }



      var extractData;
      $("#mySidebar").click(function(event){
        var id=event.target.id;
        if(id!=="mySidebar"){
          $("#"+id+"_content").show();
        }

      });

      console.log(extractData);
  });



  </script>

</body>
