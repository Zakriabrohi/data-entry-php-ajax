<?php
include("database.php");
$dbobject = new Database();
$dbobject->Getconnection();

// ---- INSERT LOGIC (UNCHANGED) ----
if (isset($_POST['add'])) {
    if (!isset($_POST['demanderid']) || !isset($_POST['enrollment'])) {
        die("Invalid request parameters");
    }

    $demanderid = $_POST['demanderid'];
    $enrollmentData = $_POST['enrollment'] ?? [];
    
    if (!is_array($enrollmentData)) {
        die("Invalid enrollment data format");
    }

    $hasValidData = false;
    
    foreach ($enrollmentData as $classData) {
        if (!isset($classData['class']) || !is_array($classData)) {
            continue;
        }
        
        $className = $classData['class'];
        
        foreach (['sindhi', 'urdu', 'english'] as $medium) {
            if (!empty($classData[$medium]) && is_array($classData[$medium])) {
                $mediumData = $classData[$medium];
                $dataToInsert = [];
                
                foreach (['total', 'male', 'female', 'muslim', 'nonmuslim', 'engurdu', 'engsindhi'] as $field) {
                    if (isset($mediumData[$field]) && is_numeric($mediumData[$field]) && $mediumData[$field] >= 0) {
                        $dataToInsert[$field] = (int)$mediumData[$field];
                    }
                }
                
                if (!empty($dataToInsert)) {
                    $hasValidData = true;
                    $dbobject->InsertEnrollment(
                        $demanderid,
                        $className,
                        $medium,
                        $dataToInsert
                    );
                }
            }
        }
    }
    
    echo $hasValidData ? 
         "<p style='color:green;font-family:Arial;font-size:16px;'>✅ Data submitted successfully!</p>" : 
         "<p style='color:red;font-family:Arial;font-size:16px;'>⚠ No valid data to submit</p>";
    exit;
}

// ---- DESIGN APPLIED TO DROPDOWNS ----
$selectStyle = "style='padding:10px;width:250px;border:1px solid #ccc;border-radius:6px;
                font-size:15px;font-family:Arial;margin:10px;'";

if(isset($_GET['load'])){
    echo "<center><h2 style='font-family:Arial;color:#2c3e50;'>Select Region</h2>";
    echo "<select id='region' $selectStyle><option>Select Region</option>";
    $result = $dbobject->GetRegion();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['regionid']."'>".$row['region']."</option>";
        }
    }
    echo "</select></center>";
}
else if(isset($_GET['regionid'])){
    echo "<center><h2 style='font-family:Arial;color:#2c3e50;'>Select District</h2>";
    echo "<select id='district' $selectStyle><option>Select District</option>";
    $result = $dbobject->GetDistrict();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['districtid']."'>".$row['district']."</option>";
        }
    }
    echo "</select></center>";
}
else if(isset($_GET['districtid'])){
    echo "<center><h2 style='font-family:Arial;color:#2c3e50;'>Select Taluka</h2>";
    echo "<select id='taluka' $selectStyle><option>Select Taluka</option>";
    $result = $dbobject->GetTaluka();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['talukaid']."'>".$row['taluka']."</option>";
        }
    }
    echo "</select></center>";
}
else if(isset($_GET['talukaid'])){
    echo "<center><h2 style='font-family:Arial;color:#2c3e50;'>Select Demander</h2>";
    echo "<select id='demander' $selectStyle><option>Select Demander</option>";
    $result = $dbobject->GetDemander();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['demanderid']."'>".$row['demander_name']."</option>";
        }
    }
    echo "</select></center>";
}
else if(isset($_GET['demanderid'])){
   $demanderid=$_GET['demanderid'];

    echo('<title>Class and Medium Enrollment</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f9f9f9; }
        table { border-collapse: collapse; width: 95%; margin:20px auto; background:white;
                box-shadow:0 3px 6px rgba(0,0,0,0.1); border-radius:8px; overflow:hidden; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size:14px; }
        th { background-color: #34495e; color:white; }
        tr:nth-child(even){ background:#f8f8f8; }
        input { width: 60px; padding:5px; text-align:center; border:1px solid #ccc; border-radius:4px; }
        button { background:#2ecc71; color:white; padding:10px 25px; border:none; border-radius:6px;
                 font-size:16px; cursor:pointer; transition:0.3s; }
        button:hover { background:#27ae60; }
        .section-title { padding:12px; font-size:15px; font-weight:bold; }
    </style>
    <table>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">Class</th>
            <th colspan="5" style="background:#e74c3c;">Sindhi Medium</th>
            <th colspan="5" style="background:#f39c12;">Urdu Medium</th>
            <th colspan="7" style="background:#3498db;">English Medium</th>
        </tr>
        <tr>
            <!-- Sindhi Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th>
            <!-- Urdu Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th>
            <!-- English Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th><th>Urdu</th><th>Sindhi</th>
        </tr>');

    $classes = ["Kachi","I","II","III","IV","V","VI","VII","VIII",
                "IX-Biology Group","IX-Computer Group","IX-Gender Group",
                "X-Biology Group","X-Computer Group","X-Gender Group"];
    foreach ($classes as $index => $class) {
        echo "<tr>
            <td>".($index + 1)."</td>
            <td style='font-weight:bold;'>$class</td>
            <!-- Sindhi Medium -->
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <!-- Urdu Medium -->
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <!-- English Medium -->
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
            <td><input type='number' value='0'></td>
        </tr>";
    }

    echo("<tr><td colspan='17' style='text-align:center; padding:20px;'>
              <button id='submitbtn'>📤 Upload Data</button>
          </td></tr>");
    echo('</table>');
}
?>
