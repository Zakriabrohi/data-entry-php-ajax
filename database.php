<?php
class Database {
    private $conn;
    public function Getconnection() {
        $this->conn = new mysqli("localhost", "root", "", "textbookboard");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function GetRegion() {
        $query = "SELECT * FROM region";
        return $this->conn->query($query);
    }
    
    public function GetDistrict() {
        $query = "SELECT * FROM district";
        return $this->conn->query($query);
    }
    
    public function GetTaluka() {
        $query = "SELECT * FROM taluka";
        return $this->conn->query($query);
    }
    
    public function GetDemander() {
        $query = "SELECT * FROM demander";
        return $this->conn->query($query);
    }
    
    public function GetEnrollment() {
        $query = "SELECT * FROM enrollment";
        return $this->conn->query($query);
    }
    
    public function GetSindhiMedaim() {
        $query = "SELECT * FROM enrollment WHERE enrollment_mediam = 'sindhi' ORDER BY enrollment_class ASC";
        return $this->conn->query($query);
    }
    
    public function GetUrduMedaim() {
        $query = "SELECT * FROM enrollment WHERE enrollment_mediam = 'urdu' ORDER BY enrollment_class ASC";
        return $this->conn->query($query);
    }
    
    public function GetEnglishMedaim() {
        $query = "SELECT * FROM enrollment WHERE enrollment_mediam = 'english' ORDER BY enrollment_class ASC";
        return $this->conn->query($query);
    }

    public function GetEnrollmentByDemander($demanderid) {
        $query = "SELECT * FROM enrollment 
                  WHERE demanderid = '$demanderid' 
                  ORDER BY 
                  CASE enrollment_class
                      WHEN 'Kachi' THEN 1
                      WHEN 'I' THEN 2
                      WHEN 'II' THEN 3
                      WHEN 'III' THEN 4
                      WHEN 'IV' THEN 5
                      WHEN 'V' THEN 6
                      WHEN 'VI' THEN 7
                      WHEN 'VII' THEN 8
                      WHEN 'VIII' THEN 9
                      WHEN 'IX-Biology Group' THEN 10
                      WHEN 'IX-Computer Group' THEN 11
                      WHEN 'IX-Gender Group' THEN 12
                      WHEN 'X-Biology Group' THEN 13
                      WHEN 'X-Computer Group' THEN 14
                      WHEN 'X-Gender Group' THEN 15
                  END,
                  FIELD(enrollment_mediam, 'sindhi', 'urdu', 'english')";
        return $this->conn->query($query);
    }
    

    public function UpdateEnrollment($data) {
        foreach ($data as $enrollmentid => $fields) {
            $enrollmentid = $this->conn->real_escape_string($enrollmentid);
            $updates = [];
            
            foreach ($fields as $field => $value) {
                $safeValue = $this->conn->real_escape_string($value);
                $updates[] = "`$field` = '$safeValue'";
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE enrollment SET " . implode(', ', $updates) . " WHERE enrollmentid = '$enrollmentid'";
                $this->conn->query($sql);
            }
        }
        return "Update successful!";
    }      
    // ... (keep your other methods unchanged) ...
           public function InsertEnrollment($demanderid, $class, $medium, $data) {
            // Set default values with new fields
            $total = $data['total'] ?? 0;
            $male = $data['male'] ?? 0;
            $female = $data['female'] ?? 0;
            $muslim = $data['muslim'] ?? 0;
            $nonmuslim = $data['nonmuslim'] ?? 0;
            $urdu = $data['engurdu'] ?? 0;  // Changed variable name to match DB column
            $sindhi = $data['engsindhi'] ?? 0;  // Changed variable name to match DB column
        
            $sql = "INSERT INTO enrollment (
                    demanderid, enrollment_class, enrollment_mediam, 
                    enrollment_no_of_students, no_of_boys, no_of_girls, 
                    no_of_muslims, no_of_nomuslims, urdu, sindhi
                ) VALUES (
                    '$demanderid', '$class', '$medium', 
                    '$total', '$male', '$female', 
                    '$muslim', '$nonmuslim', '$urdu', '$sindhi'
                )";
            
            return $this->conn->query($sql);
        }
        // ... rest of your methods ...
    
    public function AddRegion($region) {
        $query = "INSERT INTO region(region) VALUES ('$region')";
        return $this->conn->query($query);
    }
    
    public function AddDistrict($regionid, $district) {
        $query = "INSERT INTO district(regionid, district) VALUES ('$regionid', '$district')";
        return $this->conn->query($query);
    }
    
    public function AddTaluka($districtid, $taluka) {
        $query = "INSERT INTO taluka(districtid, taluka) VALUES ('$districtid', '$taluka')";
        return $this->conn->query($query);
    }
    public function AddDemander($talukaid,$name,$designation,$cnic,$mobile,$image,$imageupload ,$schools,$Accadmic){
        $query = "INSERT INTO demander(	talukaid, demander_name , demander_designation ,demander_cnic , demander_mobile , demander_image , demander_image_upload , no_of_schools ,accadmic_year) 
        VALUES 
        ('$talukaid','$name','$designation' ,'$cnic','$mobile','$image','$imageupload' ,'$schools' ,'$Accadmic')";
        return $this->conn->query($query);
    }
}    


/*
 my database enrollment table colums . 
 # | name                   | type        | null | Default
 1 |  demanderid            | int (11)    | Yes  | Null  
 2 |  enrollmentid          | int (11)    | No   | none  
 3 |  enrollment_class	    | varchar(50) | Yes  | Null  
 4 |  enrollment_mediam     | varchar(50) | Yes  | Null  
 5 |  enrollment_no_of_students | int (255)    | Yes  | Null  
 6 |  no_of_boys            | int (255))    | Yes  | Null  
 7 |  no_of_girls           | int (255)    | Yes  | Null  
 8 |  no_of_muslims         | int (255)    | Yes  | Null  
 9 |  no_of_nomuslims       | int (255)    | Yes  | Null  
 10 |  urdu                 | int (255)    | Yes  | Null  
 11 |  english              | int (255)    | Yes  | Null  
*/
?>