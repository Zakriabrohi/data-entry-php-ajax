<?php
include("database.php");
$dbobject = new Database();
$dbobject->Getconnection();

// In the POST add section of reportview.php
// In the POST add section
if (isset($_POST['add'])) {
    // Validate required parameters
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
                
                // Include new fields here
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
    
    if ($hasValidData) {
        echo "Data submitted successfully!";
    } else {
        echo "No valid data to submit";
    }
    exit;
}
// Rest of your code remains the same...

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
   $demanderid=$_GET['demanderid'];
    $result = $dbobject->GetEnrollment();
    $row = $result->num_rows;

    echo('<title>Class and Medium Enrollment</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        input { width: 60px; text-align: center; }
    </style>
    <table>
        <tr>
            <th rowspan="2">S.No</th>
            <th rowspan="2">Class</th>
            <th colspan="5" style="background-color: #f88;" class="sindhi_medaim" id="sindhi_medaim">Sindhi Medium</th>
            <th colspan="5" style="background-color: #ff8;" class="urdu_medaim" id="urdu_medaim">Urdu Medium</th>
            <th colspan="7" style="background-color: #8cf;" class="english_medaim" id="english_medaim">English Medium</th>
        </tr>
        <tr>
            <!-- Sindhi Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th>
            <!-- Urdu Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th>
            <!-- English Medium -->
            <th>Total</th><th>Male</th><th>Female</th><th>Muslim</th><th>Non-Muslim</th><th>Urdu</th><th>Sindhi</th>
        </tr>');

    $classes = ["kachi","I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX-Biology Group", "IX-Computer Group", "IX-Gender Group", "X-Biology Group", "X-Computer Group", "X-Gender Group"];
    foreach ($classes as $index => $class) {
        echo "<tr>
            <td>" . ($index + 1) . "</td>
            <td>$class</td>
            <!-- Sindhi Medium -->
            <td><input type='number' name='sindhi_total[]' value='0'></td>
            <td><input type='number' name='sindhi_male[]' value='0'></td>
            <td><input type='number' name='sindhi_female[]' value='0'></td>
            <td><input type='number' name='sindhi_muslim[]' value='0'></td>
            <td><input type='number' name='sindhi_nonmuslim[]' value='0'></td>
            <!-- Urdu Medium -->
            <td><input type='number' name='urdu_total[]' value='0'></td>
            <td><input type='number' name='urdu_male[]' value='0'></td>
            <td><input type='number' name='urdu_female[]' value='0'></td>
            <td><input type='number' name='urdu_muslim[]' value='0'></td>
            <td><input type='number' name='urdu_nonmuslim[]' value='0'></td>
            <!-- English Medium -->
            <td><input type='number' name='english_total[]' value='0'></td>
            <td><input type='number' name='english_male[]' value='0'></td>
            <td><input type='number' name='english_female[]' value='0'></td>
            <td><input type='number' name='english_muslim[]' value='0'></td>
            <td><input type='number' name='english_nonmuslim[]' value='0'></td>
            <td><input type='number' name='english_engurdu[]' value='0'></td>
            <td><input type='number' name='english_engsindhi[]' value='0'></td>
        </tr>";
    }

    echo("<tr><td colspan='17'><button id='submitbtn'>Upload Data</button></td></tr>");
    echo('</table>');
}
?>