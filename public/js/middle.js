function testAjax() {
    return $.ajax({
        method: "GET",
        url: "http://localhost:3000",
        success: function(tables) {
            let operators = [];
            tables.forEach(function(item) {
                var cols = [];
                var external_cols = [];
                var input_cols = [];
                var outputs = [];
                item.columns.forEach(function(col) {
                    cols.push(col.name);
                });

                if (item.foreignKeys) {
                    item.foreignKeys.forEach(function(key) {
                        key.columns.forEach(function(col, idx) {
                            external_cols.push(col.column);
                            var output = {
                                column: col.column,
                                table: key.reference.table,
                                field: key.reference.columns[idx].column
                            };
                            outputs.push(output);
                        });
                    });
                }
                input_cols = cols.filter(x => !external_cols.includes(x));
                let operator = {
                    name: item.name,
                    inputs: input_cols,
                    outputs: outputs
                };
                operators.push(operator);
            });

            var i = 1;
            var data = {};
            var operator = "operator" + i;
            data["operators"] = {};
            data["operators"][operator] = {};

            let links_table = {};
            data["links"] = {};
            operators.forEach(function(item) {
                let j = 1;
                let k = 1;
                max=Math.ceil(100);
                min=Math.floor(1);
                data["operators"][operator] = {};
                data["operators"][operator]["top"] = Math.random() * (max - min) + min;
                data["operators"][operator]["left"] = Math.random() * (max - min) + min;
                data["operators"][operator]["properties"] = {};
                data["operators"][operator]["properties"]["title"] = item.name;
                data["operators"][operator]["properties"]["inputs"] = {};
                links_table[item.name] = {
                    operator: operator,
                    inputs: [],
                    outputs: []
                };
                item.inputs.forEach(function(input) {
                    let inp = "input_" + j;
                    data["operators"][operator]["properties"]["inputs"][inp] = {
                        label: input
                    };
                    let obj = {};
                    obj[input] = inp;
                    links_table[item.name].inputs.push(obj);
                    j++;
                });
                data["operators"][operator]["properties"]["outputs"] = {};
                item.outputs.forEach(function(output) {
                    let outp = "output_" + k;
                    let col = output.column;
                    data["operators"][operator]["properties"]["outputs"][
                        outp
                    ] = { label: col };
                    let obj = {};
                    obj[col] = outp;
                    obj["table"] = output.table;
                    obj["field"] = output.field;
                    links_table[item.name].outputs.push(obj);
                    k++;
                });
                i++;
                operator = "operator" + i;
            });

            i = 1;
            links = {};
            operators.forEach(function(item) {
                item.outputs.forEach(function(output) {
                    let l = "link_" + i;
                    let fromOperator = links_table[item.name].operator;
                    let fromConnector = "";
                    let toOperator = "";
                    let toConnector = "";
                    links_table[item.name].outputs.forEach(function(elem) {
                        if (elem[output.column]) {
                            fromConnector = elem[output.column];
                            if (links_table[elem["table"]]) {
                                toOperator =
                                    links_table[elem["table"]].operator;
                                links_table[elem["table"]].inputs.forEach(
                                    function(inp) {
                                        if (inp[elem["field"]]) {
                                            toConnector = inp[elem["field"]];
                                            links[l] = {
                                                fromOperator: fromOperator,
                                                fromConnector: fromConnector,
                                                toOperator: toOperator,
                                                toConnector: toConnector
                                            };
                                        }
                                    }
                                );
                            }
                        }
                    });
                    i++;
                });
            });
            data["links"] = links;
            //console.log(JSON.stringify(data));
            $("#example_2").flowchart({
                data: data,
                defaultLinkColor: "#000000",
                linkWidth: 2,
                //defaultOperatorClass: 'flowchart-custom-operator',
                onOperatorSelect: function(operatorId) {
                    openNav(
                        $flowchart,
                        operatorId,
                        $flowchart.flowchart("getOperatorData", operatorId)
                    );
                    return true;
                }
            });
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });
}
