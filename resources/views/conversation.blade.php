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
  <h3 id="testo_sidebar"> ▶ Database Overview &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Conversation editor &nbsp&nbsp&nbsp Property Editor &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Chat Preview</h3>
<div class="w3-sidebar w3-light-grey w3-bar-block" id="mySidebar" style="position:absolute; width:14%; overflow:scroll;">

</div>
<div class="sidebar_chat" id="valuesbar" style="position:absolute; right:0px; width:30%; background-color:white;  border-style:none; margin-top:0px; heigth:200px; height: 836px; overflow-y:scroll;"></div>


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
    $("#showvalues").append("<div style=\"margin-left:15px\">Mostrami:     <button class=\"link\" id=\""+dataFromCall[i].properties.title+"_values\">"+dataFromCall[i].properties.title+"</button></div>");
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
        $("#showvalues").append("<div style=\"margin-left:15px;color:#223047; \">Seleziona le tabelle che vuoi che ti vengano mostrate in risposta:</div><br>")
        for(var j in dataFromCall[i].properties.inputs){
          $("#showvalues").append("<div style=\"margin-left:15px\"><button class=\"buttonvalues\" id=\""+dataFromCall[i].properties.inputs[j].label+"_"+id.substring(0,(lenght-7))+"\"  > • "+dataFromCall[i].properties.inputs[j].label+"</button></div>");

        }
        for( var l in dataFromCall[i].properties.outputs){
          $("#showvalues").append("<div style=\"margin-left:15px\"><button class=\"buttonvalues\" id=\""+dataFromCall[i].properties.outputs[l].label+"_"+id.substring(0,(lenght-7))+"\"  > • "+dataFromCall[i].properties.outputs[l].label+"</button></div>");
          
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


$("body").on("click",function(event){
  var id=event.target.id;
  var string="_values";
  var len=id.length;
  if(id.substring((len-7),len)===string){
    switch(id){
      case "eroe_values":
        $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var id=event.target.id;
          switch(id){
            case "cod_mortale_eroe":
             $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_mortale:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">1234</div>");
              break;
            case "nome_eroe":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">nome:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">Sansone</div>");
            break;
            case "forza_eroe":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">forza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">5</div>");
              break;
            case "intelligenza_eroe":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">intelligenza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">8</div>");
              break;

            case "destrezza_eroe":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+id.substring(0,9)+":</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">10</div>");
            break;
          }
        });
        break;

        case "mostro_values":

        $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var id=event.target.id;
          switch(id){
            case "cod_mortale_mostro":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_mortale:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">mos24</div>");
            break;
            case "nome_mostro":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">nome:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">Troll</div>");
            break;
            case "forza_mostro":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">forza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">4</div>");
            break;
            case "intelligenza_mostro":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">intelligenza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">1</div>");
            break;
            case "destrezza_mostro":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">destrezza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">5</div>");
            break;
          }
        });
        break;

        case "arma_values":
              $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var id=event.target.id;
          switch(id){
            case "cod_oggetto_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_oggetto:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">weapon42</div>");
            break;
            case "nome_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">nome:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">alabarda</div>");
            break;
            case "peso_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">peso:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">5</div>");
            break;
            case "danno_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">danno:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">9</div>");
            break;
            case "raggio_min_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">raggio_min:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">1</div>");
            break;
            case "raggio_max_arma":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">raggio_max:</div>");
            $("#valuesbar").append("<div style=\"margin-left:15px;\">2</div>");
            break;
          }
          
        });
        break;

        case "elemento_protettivo_values":

          $("#valuesbar").append("<br>");
          $("#showvalues").on("click",function(event){
            var id=event.target.id;
            switch(id){
              case "cod_oggetto_elemento_protettivo":
                $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+id+":</div>");
                $("#valuesbar").append("<div style=\"margin-left:15px;\">armour12</div>");
              break;
              case "nome_elemento_protettivo":
                $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+id+":</div>");
                $("#valuesbar").append("<div style=\"margin-left:15px;\">armatura d'argento</div>");
            break;
            case "peso_elemento_protettivo":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+id+":</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">12</div>");
              break;
            case "resistenza_elemento_protettivo":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+id+":</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">20</div>");
              break;
            }

          });
        break;

        case "equipaggiamento_values":

          $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var id=event.target.id;
          switch(id){
            case "cod_oggetto_equipaggiamento":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_oggetto:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">armour12</div>");
              break;
            case "cod_eroe_equipaggiamento":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_eroe</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">1234</div>");
            break;

          }
        });
        break;
        case "divinita_values":

          $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var id=event.target.id;
          switch(id){
            case "cod_divinita_divinita":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_divinita:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">god32</div>");
            break;
            case "nome_divinita":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">nome:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">Nettuno</div>");
            break;
            case "influenza_divinita":
              $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">influenza:</div>");
              $("#valuesbar").append("<div style=\"margin-left:15px;\">15</div>");
            break;
          }
        });
        break;

        case "protezione_divina_values":

          $("#valuesbar").append("<br>");
        $("#showvalues").on("click",function(event){
          var ids=event.target.id;
          switch(ids){
            case "cod_mortale_protezione_divina":
            $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">"+ids.substring(0,11)+":</div>");
            $("#valuesbar").append("<div style=\"margin-left:15px;\">1234</div>");
            break;
            case "cod_divinita_protezione_divina":
            $("#valuesbar").append("<div style=\"margin-left:15px;font-size:15px;font-weight:bold;color:orange;\">cod_divinita:</div>");
            $("#valuesbar").append("<div style=\"margin-left:15px;\">god32</div>");
              break;
          }
        });
        break;

    }
  }
});

    });



  </script>

</body>
