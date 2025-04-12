<?php
include("database.php");
$db = new Database();
$db->Getconnection();

$result = $db->GetClassEnrollment();

echo '<h2 style="text-align:center; color:blue;">CLASS AND MEDIUM WISE ENROLLMENT</h2>
<style>
    table { width: 100%; border-collapse: collapse; margin: 20px auto; }
    th, td { border: 1px solid #000; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    .sindhi { background-color: #d1f7c4; }
    .urdu { background-color: #f7d1d1; }
    .english { background-color: #d1d8f7; }
</style>

<table>
    <tr>
        <th rowspan="2">S.NO</th>
        <th rowspan="2">CLASS</th>
        <th colspan="5" class="sindhi">Sindhi Medium</th>
        <th colspan="5" class="urdu">Urdu Medium</th>
        <th colspan="5" class="english">English Medium</th>
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
    </tr>';

$sno = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>$sno</td>
        <td>{$row['enrollment_class']}</td>
        <td>{$row['sindhi_total']}</td>
        <td>{$row['sindhi_male']}</td>
        <td>{$row['sindhi_female']}</td>
        <td>{$row['sindhi_muslim']}</td>
        <td>{$row['sindhi_nonmuslim']}</td>
        <td>{$row['urdu_total']}</td>
        <td>{$row['urdu_male']}</td>
        <td>{$row['urdu_female']}</td>
        <td>{$row['urdu_muslim']}</td>
        <td>{$row['urdu_nonmuslim']}</td>
        <td>{$row['english_total']}</td>
        <td>{$row['english_male']}</td>
        <td>{$row['english_female']}</td>
        <td>{$row['english_muslim']}</td>
        <td>{$row['english_nonmuslim']}</td>
    </tr>";
    $sno++;
}

echo '</table>';
?>