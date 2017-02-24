<?php
include("DBArrayQuery.php");
//include("conexionDB.php");

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
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'UserIDToken'));
    ConexionDB_JSON($query);     
}
function DeletePatientParams($array_input) {
    global $DBtables;
    $query = "DELETE FROM " . $DBtables['patients'] . " WHERE ";
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'PatientIDToken'));
    ConexionDB_JSON($query);     
}
function DeleteCompanyParams($array_input) { 
    global $DBtables;
    $query = "DELETE FROM " . $DBtables['company'] . " WHERE ";
    $query .= where_equal_value(untoken_array(get_array_element_by_key($array_input), 'CompanyIDToken'));
    ConexionDB_JSON($query); 
}
function InsertPatientParams($array_input) { 
    global $DBtables;
    $query = "INSERT INTO " . $DBtables['patients'] . "(" . set_key_list(untoken_array($array_input)) . ")";
    $query .= "VALUES" . "(" . insert_key_value(untoken_array($array_input)) .  ")";
    ConexionDB_JSON($query);        
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
    $wherecondition = get_array_element_by_key($array_input, 'PatientIDToken');
    unset($array_input['PatientIDToken']);
    $query = "UPDATE " . $DBtables['patients'] . " SET " . set_key_value(untoken_array($array_input));
    $query .= " WHERE "  . where_equal_value(untoken_array($wherecondition)) ;
    ConexionDB_JSON($query);
}
function UpdateCompanyParams($array_input) { 
    global $DBtables;
    $wherecondition = get_array_element_by_key($array_input, 'CompanyIDToken');
    unset($array_input['CompanyIDToken']);
    $query = "UPDATE " . $DBtables['company'] . " SET " . set_key_value(untoken_array($array_input));
    $query .= " WHERE "  . where_equal_value(untoken_array($wherecondition)) ;
    print $query;
    ConexionDB_JSON($query);
}
function UpdateUsersParams($array_input) { 
    global $DBtables;
    $wherecondition = get_array_element_by_key($array_input, 'UserIDToken');
    unset($array_input['UserIDToken']);
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

