<?php
include("DBArrayQuery.php");
//include("conexionDB.php");

function ReadCompanyListParams($array_input) { 
    global $DBtables;
    $query = "SELECT CompanyID FROM " . $DBtables['company'] . " WHERE 1";
    ConexionDB_JSON($query);
}
function UpdateUserPWDParams ($array_input) { 
    global $DBtables;
    $bytes = random_bytes(15);
    $hex   = bin2hex($bytes);
    $HASHvar = hash("sha256", $hex);
    $query = "UPDATE " . $DBtables['users'] . " SET PassHash = '" . $HASHvar  . "' ";
    $query .= "WHERE UserID = '" . get_array_element_by_key($array_input, 'UserID_Token')['UserID_Token'] . "'";  
    ConexionDB_JSON($query);  
}
function ReadCompanyParams($array_input) { 
    global $DBtables;
    $query = "SELECT * FROM " . $DBtables['company'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);
}
function ReadPatientParams($array_input) {  
    global $DBtables;
    $query = "SELECT * FROM " . $DBtables['patients'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);    
}
function getCheckparams($array_input, $tablename, $label, $enableJSON=FALSE) {  
    global $DBtables;
    $query = "SELECT CASE WHEN COUNT( * ) >0 THEN  'TRUE' ELSE  'FALSE' END AS  '" . $label ."' FROM  " . $DBtables[$tablename] . " WHERE ";
    $query .= where_equal_value(untoken_array($array_input));
    $result = ConexionDB_rawdata($query);
    if($enableJSON) {
        print json_encode($result);
       }
    return $result;
}
function ReadEvaluationConstParams($array_input) {  
    global $DBtables;
    $query = "SELECT * FROM " . $DBtables['evaluationconts'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);    
}
function ReadUsersParams($array_input) {  
    global $DBtables;
    $query = "SELECT * FROM " . $DBtables['users'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);    
}
function DeleteUsersParams($array_input) {
    global $DBtables;
    $query = "DELETE FROM " . $DBtables['users'] . " WHERE ";
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'UserID_Token'));
    ConexionDB_JSON($query);     
}
function DeletePatientParams($array_input) {
    global $DBtables;
    $query = "DELETE FROM " . $DBtables['patients'] . " WHERE ";
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'PatientID_Token'));
    ConexionDB_JSON($query);     
}
function DeleteCompanyParams($array_input) { 
    global $DBtables;
    $query = "DELETE FROM " . $DBtables['company'] . " WHERE ";
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'CompanyID_Token'));
    ConexionDB_JSON($query); 
}
function InsertPatientParams($array_input) { 
    global $DBtables;
    $query = "INSERT INTO " . $DBtables['patients'] . "(" . set_key_list(untoken_array($array_input)) . ")";
    $query .= "VALUES" . "(" . insert_key_value(untoken_array($array_input)) .  ")";
    ConexionDB_JSON($query);        
}
function InsertEvaluationHistoryParams($array_input) { 
    global $DBtables;
    $first_array = get_array_element_by_key_pull(untoken_array($array_input), 'PatientID');
    unset($array_input['PatientID_Token']);
    $second_array = get_array_element_by_key_pull(untoken_array($array_input), 'ModifierID');
    unset($array_input['ModifierID_Token']);
    $pivot_array = array_merge($first_array, $second_array);
    $output = ""; 
    $firstRun = true;
    foreach(untoken_array($array_input) as $key=>$val) { 
        if(!$firstRun) { 
            $output .= ","; 
        } else { 
            $firstRun = false; 
        } 
        $output .= "(" . set_value_list($pivot_array) . ",'" .$key . "'," . "'" .$val . "')";     
    } 
    $query = "INSERT INTO " . $DBtables['evaluationhistory'] . "(" . set_key_list($pivot_array). ",Test, Value" . ")";
    $query .= "VALUES" . $output;
    ConexionDB_JSON($query);        
}
function InsertGenericParams($array_input, $tablename) { 
    global $DBtables;
    $query = "INSERT INTO " . $DBtables[$tablename] . "(" . set_key_list(untoken_array($array_input)) . ")";
    $query .= "VALUES" . "(" . insert_key_value(untoken_array($array_input)) .  ")";
    ConexionDB_JSON($query);        
}
function ReadPatientHistoryParams($array_input){
    global $DBtables;
    $patient = get_array_element_by_key_pull(untoken_array($array_input), 'PatientID');
    unset($array_input['PatientID_Token']);
    $query = "SELECT * FROM " . $DBtables['evaluationhistory'] . " WHERE " . set_key_list($patient) . " = " . set_value_list($patient)  ;
    if (isset($array_input['Fromdate_Token'])) {
        $fromdate = get_array_element_by_key_pull(untoken_array($array_input), 'Fromdate');
        unset($array_input['Fromdate_Token']);
        $query .= " AND CONVERT(  " . set_value_list($fromdate) . ", DATETIME ) <= `ModDate`";
    }
    if (isset($array_input['Todate_Token'])) {
        $Todate = get_array_element_by_key_pull(untoken_array($array_input), 'Todate');
        unset($array_input['Todate_Token']);
        $query .= " AND `ModDate` < CONVERT(  " . set_value_list($Todate) . ", DATETIME ) ";
    }
    if (!empty($array_input)) {
        $query .= " AND `Test` IN (" . set_value_list(untoken_array($array_input)). ") ";      
    }
    $query .= "GROUP BY" . " `Test` " . " ORDER BY " . "`ModDate`" . " DESC";
    ConexionDB_JSON($query); 
}

function InsertParams($array_input, $tablename){
    $result_check = getCheckparams($array_input, $tablename, 'EXIST', FALSE);
    if ($result_check[0]['EXIST'] == 'FALSE') {
        InsertGenericParams($array_input, $tablename);
        $result_validation = getCheckparams($array_input, $tablename, 'VALIDATE', TRUE);
    } else {
        print json_encode($result_check);
    }
}
function InsertCompanyParams($array_input) { 
    global $DBtables;
    $query = "INSERT INTO " . $DBtables['company'] . "(" . set_key_list(untoken_array($array_input)) . ")";
    $query .= "VALUES" . "(" . insert_key_value(untoken_array($array_input)) .  ")";
    ConexionDB_JSON($query);  
}
function InsertUsersParams($array_input) { 
    global $DBtables;
    $query = "INSERT INTO " . $DBtables['users'] . "(" . set_key_list(untoken_array($array_input)) . ")";
    $query .= "VALUES" . "(" . insert_key_value(untoken_array($array_input)) .  ")";
    ConexionDB_JSON($query);  
}
function UpdatePatientParams($array_input) { 
    global $DBtables;
    $wherecondition = get_array_element_by_key($array_input, 'PatientID_Token');
    unset($array_input['PatientID_Token']);
    $query = "UPDATE " . $DBtables['patients'] . " SET " . set_key_value(untoken_array($array_input));
    $query .= " WHERE "  . where_equal_value(untoken_array($wherecondition)) ;
    ConexionDB_JSON($query);
}
function UpdateCompanyParams($array_input) { 
    global $DBtables;
    $wherecondition = get_array_element_by_key($array_input, 'CompanyID_Token');
    unset($array_input['CompanyID_Token']);
    $query = "UPDATE " . $DBtables['company'] . " SET " . set_key_value(untoken_array($array_input));
    $query .= " WHERE "  . where_equal_value(untoken_array($wherecondition)) ;
    print $query;
    ConexionDB_JSON($query);
}
function UpdateUsersParams($array_input) { 
    global $DBtables;
    $wherecondition = get_array_element_by_key($array_input, 'UserID_Token');
    unset($array_input['UserID_Token']);
    $query = "UPDATE " . $DBtables['users'] . " SET " . set_key_value(untoken_array($array_input));
    $query .= " WHERE "  . where_equal_value(untoken_array($wherecondition)) ;
    ConexionDB_JSON($query);
}
function LoginUserParams() {      }

function untoken_array($array){
    $output = array();
    foreach($array as $key=>$val) { 
            $output[getQuerystatement($key)] =  $val;
    } 
    return $output;
}

function where_like_value($array)
{
    $output = ""; 
    $firstRun = true; 
    foreach($array as $key=>$val) { 
        if(!$firstRun) { 
            $output .= " AND "; 
        } else { 
            $firstRun = false; 
        } 
        $output .= "`" . $key . "`" . " LIKE ". "'" .$val . "'";     
    } 
    return $output;
}

function where_equal_value($array)
{
    $output = ""; 
    $firstRun = true; 
    foreach($array as $key=>$val) { 
        if(!$firstRun) { 
            $output .= " AND "; 
        } else { 
            $firstRun = false; 
        } 
        $output .= "`" . $key . "`" . " = ". "'" .$val . "'";     
    } 
    return $output;
}
function set_key_value($array)
{
        $output = ""; 
        $firstRun = true; 
        foreach($array as $key=>$val) { 
            if(!$firstRun) { 
                $output .= ","; 
            } else { 
                $firstRun = false; 
            } 
            $output .= "`" . $key . "`" . " = ". "'" .$val . "'";     
    } 
return $output;
} 

function set_key_list($array)
{
        $output = ""; 
        $firstRun = true; 
        foreach($array as $key=>$val) { 
            if(!$firstRun) { 
                $output .= ","; 
            } else { 
                $firstRun = false; 
            } 
            $output .= "`" . $key . "`";     
    } 
return $output;
}
function set_value_list($array)
{
        $output = ""; 
        $firstRun = true; 
        foreach($array as $key=>$val) { 
            if(!$firstRun) { 
                $output .= ","; 
            } else { 
                $firstRun = false; 
            } 
            $output .= "'" . $val . "'";     
    } 
return $output;
}
function insert_key_value($array)
{
        $output = ""; 
        $firstRun = true; 
        foreach($array as $key=>$val) { 
            if(!$firstRun) { 
                $output .= ","; 
            } else { 
                $firstRun = false; 
            } 
            $output .= "'" .$val . "'";     
    } 
return $output;
} 

function get_array_element_by_key($array, $key)
{
        $output = array(); 
        $output[$key] = $array[$key];
return $output;
}
function get_array_element_by_key_pull(&$array, $key)
{
        $output = array(); 
        $output[$key] = $array[$key];
        unset($array[$key]);
return $output;
} 
function set_key_value_like($array)
{
        $output = ""; 
        $firstRun = true; 
        foreach($array as $key=>$val) { 
            if(!$firstRun) { 
                $output .= ","; 
            } else { 
                $firstRun = false; 
            } 
            $output .= "`" . $key . "`" . " LIKE ". "'" .$val . "'";     
    } 
return $output;
} 

?>

