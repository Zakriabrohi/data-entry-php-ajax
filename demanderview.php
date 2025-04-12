<?php
include("database.php");
$dbobject = new Database();
$dbobject -> Getconnection();

if (isset($_POST['add'])) {
    $talukaid = $_POST['talukaid'];
    
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $cnic = $_POST['cnic'];
    $mobile = $_POST['mobile'];
   

    $target_dir = "upload/";
    $image = $target_dir . basename($_FILES['image']['name']);
    $imageupload = $target_dir . basename($_FILES['imageupload']['name']);

    $schools = $_POST['schools'];
    $Accadmic = $_POST['Accadmic'];
    $dbobject->AddDemander($talukaid,$name,$designation,$cnic,$mobile,$image,$imageupload ,$schools,$Accadmic); 
    // header("location:loginajax.html");  // Redirect after submission
    echo "<br>Successfully submitted data";
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
    echo("Select District<select id='taluka'>");
    echo("<option> Select District</option>");
    $result=$dbobject-> GetTaluka();
    $row=$result->num_rows;
   if($row>0){
    while($row=$result->fetch_assoc()){
        echo "<option value='".$row['talukaid']."'>".$row['taluka']."</option>";
    }
   }
   echo("</select>");
}

else if(isset($_GET['talukaid'])){
    echo("<center>");
    echo("<h1> Select Any Taluka </h1>");
    echo("<table border='1'>");
    echo("<tr><td>Enter Demander Name </td><th><input type='text' id='name'> </th></tr>");
    echo("<tr><td>Select designation <select id='designation'>
    <option>Select Demander_designation </option>
    <option> Primary Male </option>
    <option>Primary Female </option>
    <option>Primary Both </option>
    </select></th></tr>");
    echo("<tr><td>Enter Demander Cnic </td><th><input type='number' id='cnic'> </th></tr>");
    echo("<tr><td>Enter Demander Mobile </td><th><input type='number' id='mobile'> </th></tr>");
    echo("<tr><td>Enter Demander Image </td><th><input type='file' id='image'> </th></tr>");
    echo("<tr><td>Enter Demander Image Upload </td><th><input type='file' id='imageupload'> </th></tr>");
    echo("<tr><td>No_of_Schools </td><th><input type='number' id='schools'> </th></tr>");
    echo("<tr><td> Accadmic Year  </td><th><input type='number' id='Accadmic'> </th></tr>");
    echo("<tr><th colspan='2'><button id='submitbtn'>Submit </button></th> </tr>");
}




?>