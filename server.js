const port = 3000;
const port2=5000;
const port3=4000;
var express = require("express");
const bodyparser=require("body-parser");
var fs = require("fs");
const { Parser } = require("sql-ddl-to-json-schema");
const { getLatestFileName } = require("./resources/js/fileNameController");
const cors=require("cors");

const parser = new Parser("mysql");
var app = express();
var app2=express();
app2.use(cors());
app2.use(bodyparser.urlencoded());
app2.use(bodyparser.json());


app.get("/", function(req, res) {

    let latestFile = getLatestFileName();

    //  fs.readFile('./storage/app/uploads/TestTables.sql' + req.query.file, 'utf8', function (err,sql) {
    fs.readFile("./storage/app/uploads/" + latestFile, "utf8", function(
        err,
        sql
    ) {
        console.log(req.query.file);
        if (err) {
            return console.log(err);
        }
        console.log(sql);
        const options = {};
        parser.feed(sql);
        const parsedJsonFormat = parser.results;
        const compactJsonTablesArray = parser.toCompactJson(parsedJsonFormat);
        //console.log(JSON.stringify(compactJsonTablesArray, null, 2));
        for (var elem in compactJsonTablesArray) {
            console.log(JSON.stringify(elem));
        }
        res.writeHead(200, {
            "Content-Type": "application/json",
            "Access-Control-Allow-Origin": "*"
        });
        res.end(JSON.stringify(compactJsonTablesArray));
    });
    var file = req.query.file;
    //res.send(file);
});



app.listen(port, () => {
    console.log(`Server listening at http://localhost:${port}`);
});





var data;
app2.post("/",function(req,res){
  console.log("body:" + JSON.stringify(req.body));
  data=req.body;
    res.end();

});

app2.get("/",function(req,res){
    res.send(data['operators']);
    res.end();
});

app2.listen(port2,function(data){
    console.log("Receveing on 5000");
});




