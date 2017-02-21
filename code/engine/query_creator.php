<?php
include("DBArrayQuery.php");


function ReadCompanyParams($array_input) { 
    print "inside readcompanyparams";
    print_r($array_input);
    print "\n";
    global $DBtables;
    
    $query = "SELECT * FROM " . $DBtables['company'] . " WHERE ";
    
    $output = ""; 
    $firstRun = true; 
    foreach($array_input as $key=>$val) { 
        if(!$firstRun) { 
            $output .= " AND "; 
        } else { 
            $firstRun = false; 
        } 
        $output .= "`" . $key . "`" . " LIKE ". "'" .$val . "'";     
    } 
    $query .= $output;
    print $query;
    //AND PatientID LIKE $PatientID_Param";
            //'SELECT * from Companies WHERE 1';
}
function ReadPatientParams() {  print "en update patient" ;  }
function DeletePatientParams() {  }
function DeleteCompanyParams() {  }
function InsertPatientParams() {  }
function InsertCompanyParams() {  }
function UpdatePatientParams() {  }
function UpdateCompanyParams() {  print "en update patient" ;}
function LoginUserParams() {      }

?>

