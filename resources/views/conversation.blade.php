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
  <h3 id="testo_sidebar"> ▶ Database Overview &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Conversation editor &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp                                           Property Editor</h3>
<div class="w3-sidebar w3-light-grey w3-bar-block" id="mySidebar" style="position:absolute; width:14%; overflow:scroll;">

</div>
<div class="w3-sidebar w3-light-grey w3-bar-block" id="valuesbar" style="position:absolute; right:0px; width:25%; background-color:white; border-color:grey; border-style:solid; margin-top:20px; heigth:100%; overflow:scroll;"></div>
<p id="testo_container">Negli esempi seguenti, clicca le parti del discorso evidenziate per modificarle con i vocabili che ritieni userebbe l'utente. A ciascuna parte evidenziata associa i dati che desideri siano restituiti come risposta.</p>
<div class="container">
<div class="middlepane" id="showvalues"></div>
</div>



  <script type="text/javascript">
  var dataExported;
  var dataFromCall;

  $.ajax({
    method:'GET',
    url:'http://localhost:5000',
    async:false,
    success:function(data){
      dataFromCall=data;
    }

  });

  $(document).ready(function(){
    console.log(dataFromCall);
    console.log(dataFromCall);


    for(var i in dataFromCall){
      $("#mySidebar").append("<button type=\"button \"class=\"collapsible\" id=\""+dataFromCall[i].properties.title+"\">"+dataFromCall[i].properties.title+"</button>");
      $("#mySidebar").append("<div class=\"content\" id=\""+dataFromCall[i].properties.title+"_content"+"\"></div>");
      $("#mySidebar").append("<br>");
      for(var j in dataFromCall[i].properties.inputs){
        $("#"+dataFromCall[i].properties.title+"_content").append(dataFromCall[i].properties.inputs[j].label+"<br>");
      }
      for(var k in dataFromCall[i].properties.outputs){
        $("#"+dataFromCall[i].properties.title+"_content").append(dataFromCall[i].properties.outputs[k].label+"<br>");
      }
      if(dataFromCall[i].properties.class==="flowchart-primary"){
        console.log("ok");
        $("#"+dataFromCall[i].properties.title).addClass("collapsible-primary");
        $("#"+dataFromCall[i].properties.title+"_content").addClass("content-primary");
      }
      if(dataFromCall[i].properties.class==="flowchart-secondary"){
        $("#"+dataFromCall[i].properties.title).addClass("collapsible-secondary");
        $("#"+dataFromCall[i].properties.title+"_content").addClass("content-secondary");
      }
      if(dataFromCall[i].properties.class=="flowchart-crossable"){
        $("#"+dataFromCall[i].properties.title).addClass("collapsible-crossable");
        $("#"+dataFromCall[i].properties.title+"_content").addClass("content-crossable");
      }
    }

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



$("body").on("click",function(event){
  var id=event.target.id;
  var flag=0;
  for(var i in dataFromCall){
    if(id===dataFromCall[i].properties.title){
      flag=1;
    $("#showvalues").append("<div style=\"margin-left:15px\">Mostrami:     <button class=\"link\" id=\""+dataFromCall[i].properties.title+"_values\">"+dataFromCall[i].properties.title+"</button></div><br>");
    }
    }
});


$("body").on("click",function(event){
  var id=event.target.id;
  var lenght=id.length;
  console.log(lenght);
  var string="_values";
  if(id.substring((lenght-7),lenght)==="_values"){
    for(var i in dataFromCall){
      if(dataFromCall[i].properties.title===id.substring(0,(lenght-7))){
        console.log("ok");
        for(var j in dataFromCall[i].properties.inputs){
          $("#showvalues").append("<div style=\"margin-left:15px\"><button class=\"buttonvalues\" id=\""+dataFromCall[i].properties.inputs[j].label+"\"  > • "+dataFromCall[i].properties.inputs[j].label+"</button></div>");

        }
      
        $("#showvalues").append("<br>");
         }
        
    }
  }
});

var catchId;
$("body").on("click",function(event){
  var id=event.target.id;
  console.log(id);
});

$("#valuesbar").append("ciaocaio");

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
