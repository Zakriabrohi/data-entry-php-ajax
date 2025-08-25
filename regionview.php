<?php
include("database.php");
$dbobject = new Database();
$dbobject -> Getconnection();

if(isset($_GET['add'])){
$region=$_GET['region'];
$dbobject->AddRegion($region);
    echo("<p style='color:green; font-family:Arial; font-size:16px;'>✅ Successfully Added</p>");

}

else if(isset($_GET['load'])){
    echo("<center>");
    echo("<h1 style='font-family:Arial; color:#2c3e50;'> Select Any Region </h1>");
    echo("<table border='0' cellpadding='10' cellspacing='0' style='border-collapse:collapse; width:400px; box-shadow:0 4px 8px rgba(0,0,0,0.2); border-radius:10px; overflow:hidden; font-family:Arial;'>");
    
    echo("<tr style='background:#3498db; color:white; text-align:left;'> 
            <td colspan='2' style='padding:12px; font-size:18px;'>Enter Your Region</td>
          </tr>");
    
    echo("<tr>
            <td colspan='2' style='padding:15px; text-align:center;'>
              <input type='text' id='region' 
                style='width:90%; padding:10px; border:1px solid #ccc; border-radius:8px; font-size:16px;'>
            </td>
          </tr>");
    
    echo("<tr>
            <td colspan='2' style='text-align:center; padding:15px;'>
              <button id='submitbtn' 
                style='background:#2ecc71; color:white; padding:10px 20px; border:none; border-radius:8px; font-size:16px; cursor:pointer; transition:0.3s;'>
                Submit
              </button>
            </td>
          </tr>");
    
    echo("</table>");
}



?>