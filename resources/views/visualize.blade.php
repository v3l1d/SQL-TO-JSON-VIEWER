<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visualize Flowchart</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery & jQuery UI are required -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Flowchart CSS and JS -->
    <link rel="stylesheet" href="./js/jquery.flowchart.css">
    <link rel="stylesheet" href="./js/menu.css">
    <script src="./js/jquery.flowchart.js"></script>

    <!-- navbar -->
    <ul>
  <li><a class="active" href="#home">SA-SW</a></li>
  <li><a href="#news">Salva</a></li>
  <li><a href="#contact">Apri</a></li>
  <li><a href="#about">Esporta</a></li>
</ul>




</head>

<body>

    <div id="text_over">
    <h2>Organizza il dataset: Rinomina colonne e tabelle e contrassegna le informazioni principali</h2>
  </div>


    <div id="chart_container">
		<div class="flowchart-example-container" id="flowchartworkspace"></div>
    <div class="w3-sidebar w3-bar-block w3-collapse" style="right:0" id="mySidebar">


</div>
  </div>
</div>

</div>
    <div id="output"></div>
	</div>



</div>
</div>





    <!DOCTYPE html>
    @extends('welcome')

    <script type="text/javascript">
        $.ajax({
            method: 'GET',
            url: 'http://localhost:3000',
            async:false,
            success: function(tables) {
                let operators = []
                tables.forEach(function(item) {
                    var cols = []
                    var external_cols = []
                    var input_cols = []
                    var outputs = []
                    item.columns.forEach(function(col) {
                        cols.push(col.name)
                    })

                    if (item.foreignKeys) {
                        item.foreignKeys.forEach(function(key) {
                            key.columns.forEach(function(col, idx) {
                                external_cols.push(col.column)
                                var output = {
                                    column: col.column,
                                    table: key.reference.table,
                                    field: key.reference.columns[idx].column
                                }
                                outputs.push(output)
                            })
                        })
                    }
                    input_cols = cols.filter(x => !external_cols.includes(x));
                    let operator = {
                        name: item.name,
                        inputs: input_cols,
                        outputs: outputs,
                    }
                    operators.push(operator)
                })

                var i = 1;
                var data = {}
                var operator = "operator" + i;
                data['operators'] = {}
                data['operators'][operator] = {}

                let links_table = {}
                data['links'] = {}
                operators.forEach(function(item) {
                    let j = 1
                    let k = 1
                    data['operators'][operator] = {}
                    data['operators'][operator]['top'] = Math.random() * 500;
                    data['operators'][operator]['left'] = Math.random() * 1300;
                    data['operators'][operator]['properties'] = {}
                    data['operators'][operator]['properties']['title'] = item.name;
                    data['operators'][operator]['properties']['inputs'] = {}
                    links_table[item.name] = {
                        operator: operator,
                        inputs: [],
                        outputs: []
                    }
                    item.inputs.forEach(function(input) {
                        let inp = "input_" + j
                        data['operators'][operator]['properties']['inputs'][inp] = {
                            label: input
                        }
                        let obj = {}
                        obj[input] = inp
                        links_table[item.name].inputs.push(obj)
                        j++
                    })
                    data['operators'][operator]['properties']['outputs'] = {}
                    item.outputs.forEach(function(output) {
                        let outp = "output_" + k
                        let col = output.column
                        data['operators'][operator]['properties']['outputs'][outp] = {
                            label: col
                        }
                        let obj = {}
                        obj[col] = outp;
                        obj["table"] = output.table;
                        obj["field"] = output.field;
                        links_table[item.name].outputs.push(obj)
                        k++
                    })
                    i++;
                    operator = "operator" + i;
                })

                i = 1;
                links = {}
                operators.forEach(function(item) {
                    item.outputs.forEach(function(output) {
                        let l = "link_" + i;
                        let fromOperator = links_table[item.name].operator
                        let fromConnector = "";
                        let toOperator = "";
                        let toConnector = "";
                        links_table[item.name].outputs.forEach(function(elem) {
                            if (elem[output.column]) {
                                fromConnector = elem[output.column]
                                if (links_table[elem["table"]]) {
                                    toOperator = links_table[elem["table"]].operator
                                    links_table[elem["table"]].inputs.forEach(
                                        function(inp) {
                                            if (inp[elem["field"]]) {
                                                toConnector = inp[elem["field"]]
                                                links[l] = {
                                                    fromOperator: fromOperator,
                                                    fromConnector: fromConnector,
                                                    toOperator: toOperator,
                                                    toConnector: toConnector
                                                }
                                            }
                                        })
                                }
                            }
                        })
                        i++
                    })
                })
                data['links'] = links;
                //console.log(JSON.stringify(data));
                useReturnData(data);

            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });

var returnedDatas;

function useReturnData(data){
    myvar = data;
    //console.log(myvar);
    returnedDatas=data;
    return myvar
};




        /* global $ */
        $(document).ready(function() {
          //  console.log(JSON.stringify(returnedDatas));
            var $flowchart = $('#flowchartworkspace');
            var $container = $flowchart.parent();



            // Apply the plugin on a standard, empty div...
            $flowchart.flowchart({
                data: defaultFlowchartData,
                defaultSelectedLinkColor: '#000055',
                grid: 10,
                multipleLinksOnInput: true,
                multipleLinksOnOutput: true
            });


            function getOperatorData($element) {
                var nbInputs = parseInt($element.data('nb-inputs'), 10);
                var nbOutputs = parseInt($element.data('nb-outputs'), 10);
                var data = {
                    properties: {
                        title: $element.text(),
                        inputs: {},
                        outputs: {}
                    }
                };

                var i = 0;
                for (i = 0; i < nbInputs; i++) {
                    data.properties.inputs['input_' + i] = {
                        label: 'Input ' + (i + 1)
                    };
                }
                for (i = 0; i < nbOutputs; i++) {
                    data.properties.outputs['output_' + i] = {
                        label: 'Output ' + (i + 1)
                    };
                }

                return data;
            }



            //-----------------------------------------
            //--- operator and link properties
            //--- start
            var $operatorProperties = $('#operator_properties');


            $operatorProperties.hide();

            var $linkProperties = $('#link_properties');
            $linkProperties.hide();
            var $operatorTitle = $('#operator_body');
            var $linkColor = $('#link_color');
            var tempId;
            $flowchart.flowchart({


                onOperatorSelect: function(operatorId) { //V3l1d
                  var data=$flowchart.flowchart('getOperatorData',operatorId);
                  var op= data['properties'];
                  tempId=operatorId;
                  console.log(data);
                  $('#mySidebar').show();
                  $("#mySidebar").html("<br><h3>Types</h3><button id=\"primary\">Primary</button> <button id=\"secondary\">Secondary</button> <button id=\"crossable\">Crossable</button> <br><hr><h3>Rename</h3><label style=\"display:inline-block; width: 140px;margin-top:10px;text-align: right;margin-right:10px;\">"+op['title']+"</label>" +"<input type=\"text\" id=\"title\"></input><br><hr>"+"<h3>Columns</h3>");
                  var i=0;

                  $.each(op['inputs'],function(index,value){

                    i++;
                    $('#mySidebar').append("<label style=\"display:inline-block; width: 140px;text-align: right;margin-right:10px;\">"+value['label']+"</label>" +"<input type=\"text\" id=\"input_"+i+"\"></input><br><br>");


                  });


                    return true;
                },
                onOperatorUnselect: function() {
                    $operatorProperties.hide();
                    $('#mySidebar').hide();

                    return true;
                },
                onLinkSelect: function(linkId) {
                    $linkProperties.show();
                    $linkColor.val($flowchart.flowchart('getLinkMainColor', linkId));
                    return true;
                },
                onLinkUnselect: function() {
                    $linkProperties.hide();
                    return true;
                }
            });

            $("body").on("click","button[id$=\"primary\"]",function(){ //v3l1d
                var opId=$flowchart.flowchart('getSelectedOperatorId');
                $flowchart.flowchart("addClassOperator",opId,"flowchart-primary");

            });

            $("body").on("click","button[id$=\"crossable\"]",function(){ //v3l1d table crossable color changer
                var opId=$flowchart.flowchart('getSelectedOperatorId');
                $flowchart.flowchart("addClassOperator",opId,"flowchart-crossable");
            });

            $("body").on("click","button[id$=\"secondary\"]",function(){
              var opId=$flowchart.flowchart('getSelectedOperatorId');
              $flowchart.flowchart("addClassOperator",opId,"flowchart-secondary");
            });




            $("body").on("change","input[id$=\"title\"]", function (){ //v3l1d

                var tempId=$flowchart.flowchart('getSelectedOperatorId');
                console.log(tempId);
                if(tempId!==null){
                  $flowchart.flowchart('setOperatorTitle',tempId,document.getElementById('title').value);
                }
            }); //v3l1d

            //catch input id and column


            $("body").on("click",function(event){ //v3l1d
                var id=event.target.id;

                var opId=$flowchart.flowchart("getSelectedOperatorId");
                var data=$flowchart.flowchart("getOperatorData",opId);
                console.log(id);
                var string="input_";
                if(string===id.substring(0,6)){ //catch data inside beacuse you have to verify that id is == to input_ and not to casual element of body //V3l1d
                  $("body").on("change","input[id$=\""+id+"\"]",function(event){
                    var val=document.getElementById(id).value;
                    data['properties']['inputs'][id]['label']=val;
                    $flowchart.flowchart('setOperatorData',opId,data);

                  });
                }

            });


            $operatorTitle.keyup(function() {
                var selectedOperatorId = $flowchart.flowchart('getSelectedOperatorId');
                if (selectedOperatorId != null) {
                    $flowchart.flowchart('setOperatorTitle', selectedOperatorId, $operatorTitle.val());
                }
            });

            $linkColor.change(function() {
                var selectedLinkId = $flowchart.flowchart('getSelectedLinkId');
                if (selectedLinkId != null) {
                    $flowchart.flowchart('setLinkMainColor', selectedLinkId, $linkColor.val());
                }
            });
            //--- end
            //--- operator and link properties
            //-----------------------------------------

            //-----------------------------------------
            //--- delete operator / link button
            //--- start
            $flowchart.parent().siblings('.delete_selected_button').click(function() {
                $flowchart.flowchart('deleteSelected');
            });
            //--- end
            //--- delete operator / link button
            //-----------------------------------------



            //-----------------------------------------
            //--- create operator button
            //--- start
            var operatorI = 0;
            $flowchart.parent().siblings('.create_operator').click(function() {
                var operatorId = 'created_operator_' + operatorI;
                var operatorData = {
                    top: ($flowchart.height() / 2) - 30,
                    left: ($flowchart.width() / 2) - 100 + (operatorI * 10),
                    properties: {
                        title: 'Operator ' + (operatorI + 3),
                        inputs: {
                            input_1: {
                                label: 'Input 1',
                            }
                        },
                        outputs: {
                            output_1: {
                                label: 'Output 1',
                            }
                        }
                    }
                };

                operatorI++;

                $flowchart.flowchart('createOperator', operatorId, operatorData);

            });
            //--- end
            //--- create operator button
            //-----------------------------------------




            //-----------------------------------------
            //--- draggable operators
            //--- start
            //var operatorId = 0;
            var $draggableOperators = $('.draggable_operator');
            $draggableOperators.draggable({
                cursor: "move",
                opacity: 0.7,

                // helper: 'clone',
                appendTo: 'body',
                zIndex: 1000,

                helper: function(e) {
                    var $this = $(this);
                    var data = getOperatorData($this);
                    return $flowchart.flowchart('getOperatorElement', data);
                },
                stop: function(e, ui) {
                    var $this = $(this);
                    var elOffset = ui.offset;
                    var containerOffset = $container.offset();
                    if (elOffset.left > containerOffset.left &&
                        elOffset.top > containerOffset.top &&
                        elOffset.left < containerOffset.left + $container.width() &&
                        elOffset.top < containerOffset.top + $container.height()) {

                        var flowchartOffset = $flowchart.offset();

                        var relativeLeft = elOffset.left - flowchartOffset.left;
                        var relativeTop = elOffset.top - flowchartOffset.top;

                        var positionRatio = $flowchart.flowchart('getPositionRatio');
                        relativeLeft /= positionRatio;
                        relativeTop /= positionRatio;

                        var data = getOperatorData($this);
                        data.left = relativeLeft;
                        data.top = relativeTop;

                        $flowchart.flowchart('addOperator', data);
                    }
                }
            });
            //--- end
            //--- draggable operators
            //-----------------------------------------


            //-----------------------------------------
            //--- save and load
            //--- start



              $('#flowchart-default-operator').click(function(){
                var data=$flowchart.flowchart('getOperatorData');
                console.log(data);
              });

              var xxx=$("#flowchar-operator-title").click($flowchart.flowchart('getOperatorData'));


            function Flow2Text() {
                var data = $flowchart.flowchart('getData');
                $('#flowchart_data').val(JSON.stringify(data, null, 2));
                return data;
            }

            var datas=Flow2Text();
            console.log(datas);
            $('#get_data').click(Flow2Text);

            function Text2Flow() {
                var data = JSON.parse($('#flowchart_data').val());
                $flowchart.flowchart('setData', data);
            }
            $('#set_data').click(Text2Flow);

            /*global localStorage*/
            function SaveToLocalStorage() {
                if (typeof localStorage !== 'object') {
                    alert('local storage not available');
                    return;
                }
                Flow2Text();
                localStorage.setItem("stgLocalFlowChart", $('#flowchart_data').val());
            }
            $('#save_local').click(SaveToLocalStorage);

            function LoadFromLocalStorage() {
                if (typeof localStorage !== 'object') {
                    alert('local storage not available');
                    return;
                }
                var s = localStorage.getItem("stgLocalFlowChart");
                if (s != null) {
                    $('#flowchart_data').val(s);
                    Text2Flow();
                } else {
                    alert('local storage empty');
                }
            }
            $('#load_local').click(LoadFromLocalStorage);
            //--- end
            //--- save and load
            //-----------------------------------------


        });

        var defaultFlowchartData = returnedDatas;
        if (false) console.log('remove lint unused warning', defaultFlowchartData);
 /*++++++++++[>+>+++>+++++++>++++++++++<<<<-]>>>>++++++++++++++++++.<-------------------.>----------.<--.>--------.<<++.>>+++++++++.------------.+++.+.<<.>>+++++++++++++++.------------.---.<<.>>++++++++.++.++++.+.--------.+++++++++++++.<<.>>-----------------.---.+++++++++++++.-------------.*/

    </script>

    <div id="sfondo_bottone">
  <button class="proceed" onclick=window.location="{{route('conversation')}}">OK</button>
</div>
</body>




</html>
<!--/*++++++++++[>+>+++>+++++++>++++++++++<<<<-]>>>>---.<<++.>>++++++++++++.------------.+++++++++++++++++.+++++++.<<.>>--------------------.<<.>>++++.+++.<<.>>+++++++.++.------.<<.>>--------------.++++++++++++.++.+++.-------------.<<++++++++++++.>>----.+++++++++++..-----------.<<------------.>>++++++++++++.----.--------.<<.>>+++++++++++++++++++++.-------------.+++++++++++.-------------------.<<.>>++.+++++.---.<<.>>--.--.++++++++++++.-----------.+++++++.--------.<<++++++++++++.------------.>>.+++++++++++.<<.>>++++++++.---------------.++++++++.+++.-.<<.>>------------.+++++.---.<<.>>++++++++.----.<<.>>+++++++.-.+++.++.-------------------.<<.>>++++++++.+++++.<<.>>++.-.++++.+.-----------.<<.>>+++++.+++++++.------.+++++++.-------------.<<++++++++++++.------------.>>--------.<<.>>++++++++.++++..------------.<<.>>++.+++++.---.<<.>>+++++++++++.++.-------------.++++++++++++++.+.-----.<<.>>--------------.+++++++++++++.----------.++++++++++++++.-----------------.<<.>>+++++++++++++++++++++.-------------.--------.*/

 -->
