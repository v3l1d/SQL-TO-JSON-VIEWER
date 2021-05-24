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
<div class="w3-sidebar w3-light-grey w3-bar-block" id="mySidebar" style="width:14%; overflow:scroll;">

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


    for(var i in dataFromCall){
      $("#mySidebar").append("<button type=\"button \"class=\"collapsible\">"+dataFromCall[i].name+"</button>");
      $("#mySidebar").append("<div class=\"content\" id=\""+dataFromCall[i].name+"_content"+"\"></div>");
      $("#mySidebar").append("<br>");
      for(var j in dataFromCall[i].columns){
        $("#"+dataFromCall[i].name+"_content").append(dataFromCall[i].columns[j].name+"<br>");
      }
    }

/*
    for (var k in dataFromCall){
      $("body").append("<button type=\"button\" class=\"collapsible\" id=\""+dataFromCall[k].name+"\">"+dataFromCall[k].name+"</button><br>");
        $("body").append("<div class=\"content\" id=\""+dataFromCall[k].name+"_content"+"\"><p>"+dataFromCall[k].columns+"</p></div>");


    }

*/

$("body").click(function(event){
      classId=event.target.id;
      console.log(classId);
      var flag=0;
      for(var i in dataFromCall){
        if(classId===dataFromCall[i].name){
          flag=1;
        }
      }
      if(flag===1){
        $("#"+dataFromCall[i].name+"_content").show();
      }
});

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

    });



  </script>

</body>
