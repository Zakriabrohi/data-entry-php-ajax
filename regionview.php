<?php
include("database.php");
$dbobject = new Database();
$dbobject -> Getconnection();

if(isset($_GET['add'])){
$region=$_GET['region'];
$dbobject->AddRegion($region);
}

else if(isset($_GET['load'])){
    echo("<center>");
    echo("<h1> Select Any Region </h1>");
    echo("<table border='1'>");
    echo("<tr><td>Enter Your Region </td><th><input type='text' id='region' > </th></tr>");
    echo("<tr><th colspan='2'><button id='submitbtn'>Submit </button></th> </tr>");
}




?>