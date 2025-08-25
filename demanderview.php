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
    $dbobject->AddDemander($talukaid,$name,$designation,$cnic,$mobile,$image,$imageupload,$schools,$Accadmic); 
    echo "<p style='color:green; font-family:Arial; font-size:16px;'>✅ Successfully submitted data</p>";
}

else if(isset($_GET['load'])){
    echo("<center>");
    echo("<h2 style='font-family:Arial; color:#2c3e50;'>Select Region</h2>");
    echo("<select id='region' 
            style='padding:10px; width:250px; border:1px solid #ccc; border-radius:6px; font-size:16px; font-family:Arial;'>
            <option>Select Region</option>");
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
    echo("<h2 style='font-family:Arial; color:#2c3e50;'>Select District</h2>");
    echo("<select id='district' 
            style='padding:10px; width:250px; border:1px solid #ccc; border-radius:6px; font-size:16px; font-family:Arial;'>
            <option>Select District</option>");
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
    echo("<h2 style='font-family:Arial; color:#2c3e50;'>Select Taluka</h2>");
    echo("<select id='taluka' 
            style='padding:10px; width:250px; border:1px solid #ccc; border-radius:6px; font-size:16px; font-family:Arial;'>
            <option>Select Taluka</option>");
    $result=$dbobject->GetTaluka();
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
    echo("<h1 style='font-family:Arial; color:#2c3e50;'>Enter Demander Details</h1>");
    echo("<table cellpadding='10' cellspacing='0' 
            style='border-collapse:collapse; width:600px; box-shadow:0 3px 6px rgba(0,0,0,0.15); border-radius:8px; overflow:hidden; font-family:Arial;'>");
    
    echo("<tr style='background:#3498db; color:white;'>
            <td colspan='2' style='padding:12px; font-size:18px;'>Demander Information</td>
          </tr>");
    
    echo("<tr><td>Enter Demander Name </td>
          <td><input type='text' id='name' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'></td></tr>");
    
    echo("<tr><td>Select Designation</td>
          <td><select id='designation' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'>
                <option>Select Demander_designation</option>
                <option>Primary Male</option>
                <option>Primary Female</option>
                <option>Primary Both</option>
              </select></td></tr>");
    
    echo("<tr><td>Enter Demander CNIC</td>
          <td><input type='number' id='cnic' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'></td></tr>");
    
    echo("<tr><td>Enter Demander Mobile</td>
          <td><input type='number' id='mobile' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'></td></tr>");
    
    echo("<tr><td>Upload Demander Image</td>
          <td><input type='file' id='image' 
                style='width:95%; padding:6px;'></td></tr>");
    
    echo("<tr><td>Upload Additional Image</td>
          <td><input type='file' id='imageupload' 
                style='width:95%; padding:6px;'></td></tr>");
    
    echo("<tr><td>No. of Schools</td>
          <td><input type='number' id='schools' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'></td></tr>");
    
    echo("<tr><td>Academic Year</td>
          <td><input type='number' id='Accadmic' 
                style='width:95%; padding:8px; border:1px solid #ccc; border-radius:6px;'></td></tr>");
    
    echo("<tr><td colspan='2' style='text-align:center; padding:15px;'>
              <button id='submitbtn' 
                style='background:#2ecc71; color:white; padding:10px 25px; border:none; border-radius:6px; font-size:16px; cursor:pointer;'>
                Submit
              </button>
          </td></tr>");
    
    echo("</table>");
}
?>
