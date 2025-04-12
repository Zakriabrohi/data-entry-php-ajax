<?php
include("database.php");
$dbobject = new Database();
$dbobject -> Getconnection();

if(isset($_GET['add'])){
$districtid=$_GET['districtid'];
$taluka=$_GET['taluka'];
$dbobject->AddTaluka($districtid,$taluka);
echo('successfully Added');
}

else if(isset($_GET['load'])){
    echo("<center>");
    echo("Select Region<select id='region'>");
    echo("<option> Select Region</option>");
    $result=$dbobject->GetRegion();
    $row=$result->num_rows;
   if($row>0){
    while($row=$result->fetch_assoc()){
        echo "<option value='".$row['regionid']."'>".$row['region']."</option>";
    }
   }
   echo("</select>");
}

else if(isset($_GET['regionid'])){
    echo("<center>");
    echo("Select District<select id='district'>");
    echo("<option> Select District</option>");
    $result=$dbobject->GetDistrict();
    $row=$result->num_rows;
   if($row>0){
    while($row=$result->fetch_assoc()){
        echo "<option value='".$row['districtid']."'>".$row['district']."</option>";
    }
   }
   echo("</select>");
}

else if(isset($_GET['districtid'])){
    echo("<center>");
    echo("<h1> Select Any Taluka </h1>");
    echo("<table border='1'>");
    echo("<tr><td>Enter Your Region </td><th><input type='text' id='taluka' > </th></tr>");
    echo("<tr><th colspan='2'><button id='submitbtn'>Submit </button></th> </tr>");
}




?>