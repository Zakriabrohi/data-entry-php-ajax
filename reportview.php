<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sindh Textbook Board Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            background: linear-gradient(to right, red, yellow);
            color: blue;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }
        .sub-header {
            color: green;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .form-section {
            border: 2px solid black;
            padding: 10px;
            margin-top: 10px;
            background-color: #f9f9f9;
        }
        .photo-box {
            border: 2px solid black;
            height: 120px;
            width: 120px;
            float: right;
            text-align: center;
            line-height: 120px;
            font-weight: bold;
        }
    </style>
</head>
<body>
</body>
</html>
<?php

include("database.php");
$dbobject = new Database();
$dbobject->Getconnection();
 

if (isset($_POST['demanderid']) && isset($_POST['data'])) {
    $demanderid = $_POST['demanderid'];
    $data = $_POST['data'];
    $dbobject->UpdateEnrollment($data);
    echo "Enrollment data updated successfully!";
}
if(isset($_GET['load'])){
    echo("<center>");
    echo("Select Region<select id='region'>");
    echo("<option> Select Region</option>");
    $result = $dbobject->GetRegion();
    $row = $result->num_rows;
    if($row > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['regionid']."'>".$row['region']."</option>";
        }
    }
    echo("</select>");
}
else if(isset($_GET['regionid'])){
    echo("<center>");
    echo("Select District<select id='district'>");
    echo("<option> Select District</option>");
    $result = $dbobject->GetDistrict();
    $row = $result->num_rows;
    if($row > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['districtid']."'>".$row['district']."</option>";
        }
    }
    echo("</select>");
}
else if(isset($_GET['districtid'])){
    echo("<center>");
    echo("Select Taluka<select id='taluka'>");
    echo("<option> Select taluka</option>");
    $result = $dbobject->GetTaluka();
    $row = $result->num_rows;
    if($row > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['talukaid']."'>".$row['taluka']."</option>";
        }
    }
    echo("</select>");
}
else if(isset($_GET['talukaid'])){
    echo("<center>");
    echo("Select Demander<select id='demander'>");
    echo("<option> Select Demander</option>");
    $result = $dbobject->GetDemander();
    $row = $result->num_rows;
    if($row > 0){
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['demanderid']."'>".$row['demander_name']."</option>";
        }
    }
    echo("</select>");
}
else if(isset($_GET['demanderid'])){
    $demanderid = $_GET['demanderid'];
    $result = $dbobject->GetEnrollmentByDemander($demanderid);

    // Organize data by class and medium
    $classes = [];
    while($row = $result->fetch_assoc()) {
        $class = $row['enrollment_class'];
        $medium = strtolower($row['enrollment_mediam']);
        $classes[$class][$medium] = $row;
    }

    echo '<h2 style="text-align:center; color:blue;">CLASS AND MEDIUM WISE ENROLLMENT</h2>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; text-align: center; }
        th { background-color: #f4f4f4; }
        input { width: 60px; text-align: center; }
    </style>
    <table border=2px>
        <tr>
            <th rowspan="2">S.NO</th>
            <th rowspan="2">CLASS</th>
            <th colspan="5" style="background-color: #f88;" class="sindhi">Sindhi Medium</th>
            <th colspan="5" style="background-color: #ff8;" class="urdu">Urdu Medium</th>
            <th colspan="7" style="background-color: #8cf;" class="english">English Medium</th>
        </tr>
        <tr>
            <th class="sindhi">Total</th>
            <th class="sindhi">Male</th>
            <th class="sindhi">Female</th>
            <th class="sindhi">Muslim</th>
            <th class="sindhi">Non-Muslim</th>
            <th class="urdu">Total</th>
            <th class="urdu">Male</th>
            <th class="urdu">Female</th>
            <th class="urdu">Muslim</th>
            <th class="urdu">Non-Muslim</th>
            <th class="english">Total</th>
            <th class="english">Male</th>
            <th class="english">Female</th>
            <th class="english">Muslim</th>
            <th class="english">Non-Muslim</th>
            <th class="english">Urdu</th>
            <th class="english">Sindhi</th>
        </tr>';

    $sno = 1;
    foreach($classes as $className => $mediums) {
        $sindhi = $mediums['sindhi'] ?? [];
        $urdu = $mediums['urdu'] ?? [];
        $english = $mediums['english'] ?? [];

        echo "<tr>
            <td>$sno</td>
            <td><input type='text' value='{$className}' class='form-control'></td>
            
            <!-- Sindhi Medium -->
            <td><input type='number' id='sindhi_total_{$sindhi['enrollmentid']}' value='{$sindhi['enrollment_no_of_students']}' class='form-control'></td>
            <td><input type='number' id='sindhi_male_{$sindhi['enrollmentid']}' 
                value='{$sindhi['no_of_boys']}' class='form-control'></td>
            <td><input type='number' id='sindhi_female_{$sindhi['enrollmentid']}' 
                value='{$sindhi['no_of_girls']}' class='form-control'></td>
            <td><input type='number' id='sindhi_muslim_{$sindhi['enrollmentid']}' 
                value='{$sindhi['no_of_muslims']}' class='form-control'></td>
            <td><input type='number' id='sindhi_nonmuslim_{$sindhi['enrollmentid']}' 
                value='{$sindhi['no_of_nomuslims']}' class='form-control'></td>
            
            <!-- Urdu Medium -->
            <td><input type='number' id='urdu_total_{$urdu['enrollmentid']}' 
                value='{$urdu['enrollment_no_of_students']}' class='form-control'></td>
            <td><input type='number' id='urdu_male_{$urdu['enrollmentid']}' 
                value='{$urdu['no_of_boys']}' class='form-control'></td>
            <td><input type='number' id='urdu_female_{$urdu['enrollmentid']}' 
                value='{$urdu['no_of_girls']}' class='form-control'></td>
            <td><input type='number' id='urdu_muslim_{$urdu['enrollmentid']}' 
                value='{$urdu['no_of_muslims']}' class='form-control'></td>
            <td><input type='number' id='urdu_nonmuslim_{$urdu['enrollmentid']}' 
                value='{$urdu['no_of_nomuslims']}' class='form-control'></td>
            
            <!-- English Medium -->
            <td><input type='number' id='english_total_{$english['enrollmentid']}' 
                value='{$english['enrollment_no_of_students']}' class='form-control'></td>
            <td><input type='number' id='english_male_{$english['enrollmentid']}' 
                value='{$english['no_of_boys']}' class='form-control'></td>
            <td><input type='number' id='english_female_{$english['enrollmentid']}' 
                value='{$english['no_of_girls']}' class='form-control'></td>
            <td><input type='number' id='english_muslim_{$english['enrollmentid']}' 
                value='{$english['no_of_muslims']}' class='form-control'></td>
            <td><input type='number' id='english_nonmuslim_{$english['enrollmentid']}' 
                value='{$english['no_of_nomuslims']}' class='form-control'></td>
            <td><input type='number' id='english_urdu_{$english['enrollmentid']}' 
                value='{$english['urdu']}' class='form-control'></td>
            <td><input type='number' id='english_sindhi_{$english['enrollmentid']}' 
                value='{$english['sindhi']}' class='form-control'></td>
        </tr>";
        $sno++;
    }
    
    echo "<tr><td colspan='19'><button onclick='updateEnrollment($demanderid)' 
         class='updatebtn'>Update All</button></td></tr>";
    echo '</table>';
}     
    
?>