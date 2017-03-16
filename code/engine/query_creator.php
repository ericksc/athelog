<?php
include_once "DBArrayQuery.php";
include_once "session.php";
//require('../library/Pivot.php');

//use SimpleExcel\SimpleExcel;

//require_once('../SimpleExcel/SimpleExcel.php');
//include_once "Notifications_Mail.php";

//FIXME: move to appropiate file
function EncryptPassword($string_pass){
    return hash("sha256", $string_pass);
}

$averageCbk = function($reg)
{
    return round($reg['clicks']/$reg['users'],2);
};

function simpleHtmlTable($data)
{
    // do you like spaghetti? 
    echo "<table border='1'>";
    echo "<thead>";
    foreach (array_keys($data[0]) as $item) {
        echo "<td><b>{$item}<b></td>";
    }
    echo "</thead>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $item) {
            echo "<td>{$item}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
function LogoutParams(){
    
    SessionDestroy();
    print "LogoutParams()";
    
}



//function to Check User/Pass. Intended to echo valuee to return it to Interface
//Return >0 if User/Pass match
//Return 0 if no User/Pass match
//Return -1 if Pass/User equals "NONE"

function CheckLoginParams($array_input) { 
    
    global $DBtables;
    
    $UserIDValue="NONE";
    $PassValue="NONE";
    $NumberOfTokens=0;//number of tokens found
    
    //print_r($array_input);
    
    foreach($array_input as $key=>$val) {
    
        if(strcmp($key,"UserID_Token")==0)$UserIDValue=$val;
        if(strcmp($key,"Password_Token")==0)$PassValue=$val;
        $NumberOfTokens++;
        
        //echo "<br>".$key.",".$val;
    }
    
    //echo "<br>User="+$UserIDValue;
    //echo "<br>Pass="+$PassValue;
    
    
    if( strcmp($UserIDValue,"NONE")==0 || strcmp($PassValue,"NONE")==0){
    //if(1==0){
        //echo "<br>Invalid params";
        echo "-1";//parameters are empty "NONE"

    }else{
        
        
        $query = "SELECT UserID, count(*) FROM " . $DBtables['users'] . " WHERE 1";
        $query.= " AND UserID='".$UserIDValue."'";
        $query.= " AND PassHash='".EncryptPassword($PassValue)."'";
        //echo "<br>query=".$query;
        $rawdB_result=ConexionDB_rawdata($query);//result of query
        //echo "<br>Resultado Raw=".print_r($result);//full result
        
        //echo "<br>rawdB_result".$rawdB_result["count(*)"];
        //echo "<br>rawdB_result[0]['count(*)']=".$rawdB_result[0]["count(*)"];//final result

        $result = $rawdB_result[0]["count(*)"];//the rawdB_result is a matrix where desired element is in [0]["count(*)"] position
       
        if($result==1){
            
            SessionStart($UserIDValue);
            //echo "<br>SessionStarting";
        }
        
        echo $result;
        
    }
    //end of if
}
//eof



function ReadCompanyListParams($array_input) { 
    global $DBtables;
    $query = "SELECT CompanyID FROM " . $DBtables['company'] . " WHERE 1";
    ConexionDB_JSON($query);
}
function UpdateUserPWDParams ($array_input) { 
    global $DBtables;
    $bytes = random_bytes(15);
    $hex   = bin2hex($bytes);
    $HASHvar=EncryptPassword($hex);
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
function ReadAllPatientHistorybyCompanyID($array_input){
    global $DBtables;
    $query = "SELECT `Patients`.PatientID, `Patients`.Forename, `Patients`.MiddleName, `Patients`.FirstSurname, `Patients`.SecondSurname, `Patients`.Email, `Patients`.Phone, `Patients`.BirthDate, `Patients`.JoinDate, `Patients`.Gender, `Patients`.Status, `Patients`.Income, `Companies`.CompanyID, `Companies`.Phone, `Companies`.Email, `Companies`.Address, `Companies`.Status, `Companies`.LastMod, `Companies`.ModifierID, `EvaluationHistory`.Test, `EvaluationHistory`.Value, `EvaluationHistory`.Unit, `EvaluationHistory`.ModDate, `EvaluationHistory`.FFD FROM " . $DBtables['patients'] ;
    $query .= " JOIN " . $DBtables['company'] . " ON  `Patients`.CompanyID =  `Companies`.CompanyID ";
    $query .= " JOIN " . $DBtables['evaluationhistory'];
    $query .= " ON  `EvaluationHistory`.PatientID =  `Patients`.PatientID ";
    $query .= "WHERE `Companies`.CompanyID = " . set_value_list(untoken_array(get_array_element_by_key($array_input, 'CompanyID_Token')));
    ConexionDB_JSON($query);
}
function DownloadAllPatientHistorybyCompanyID($array_input){
    global $DBtables;
    //$query = "SELECT `Patients`.PatientID, ";
    //$query .= " `Patients`.Forename, `Patients`.MiddleName, `Patients`.FirstSurname, `Patients`.SecondSurname, `Patients`.Email, `Patients`.Phone, `Patients`.BirthDate, `Patients`.JoinDate, `Patients`.Gender, `Patients`.Status, `Patients`.Income,";
    //$query = "SELECT CONCAT(  `Patients`.PatientID,  '_',  `Companies`.CompanyID ) AS  'Identificación' ,";
    //$query .= " `Companies`.CompanyID, ";
    $query = "SELECT `Patients`.PatientID as 'Cédula', `Patients`.Forename as 'Primer Nombre', `Patients`.MiddleName as 'Segundo Nombre', `Patients`.FirstSurname as 'Primer Apellido', `Patients`.SecondSurname as 'Segundo Apellido' , `Patients`.Department as 'Departamento' , `Patients`.Site as 'Sede' , `Companies`.CompanyID as 'Compañía' , ";
    //$query .= "`Companies`.Phone, `Companies`.Email, `Companies`.Address, `Companies`.Status, `Companies`.LastMod, `Companies`.ModifierID, ";
    $query .= " `EvaluationHistory`.Test as 'Exámen' , `EvaluationHistory`.Value as 'Resultado' , DATE_FORMAT(  `EvaluationHistory`.ModDate,  '%Y/%m/%d' ) AS  'Fecha' ";
    //$query .= "`EvaluationHistory`.Unit,  `EvaluationHistory`.FFD ";
    $query .= " FROM " . $DBtables['patients'] ;
    $query .= " JOIN " . $DBtables['company'] . " ON  `Patients`.CompanyID =  `Companies`.CompanyID ";
    $query .= " JOIN " . $DBtables['evaluationhistory'];
    $query .= " ON  `EvaluationHistory`.PatientID =  `Patients`.PatientID ";
    $query .= "WHERE `Companies`.CompanyID = " . set_value_list(untoken_array(get_array_element_by_key($array_input, 'CompanyID_Token')));
    $query .= " ORDER BY  'Identificación',  'Fecha' ";
    //print $query;
    $rawdata = ConexionDB_rawdata($query);
    //simpleHtmlTable($rawdata);
    
    //echo "<h2>pivot on 'host' and 'country'</h2>";
    $data = Pivot::factory($rawdata)
    ->pivotOn(array('Cédula', 'Compañía' ,'Exámen'))
    ->addColumn(array('Fecha'), array('Resultado',))
    //->fullTotal()
    //->pivotTotal()
    //->lineTotal()
    ->fetch();
    
    simpleHtmlTable($data);
    
    //$excel = new SimpleExcel('xml');                    // instantiate new object (will automatically construct the parser & writer type as XML)
     
    //$excel->writer->setData($data);     

    // add some data to the writer
    //$excel->writer->saveFile('Reporte');   
    //print_r($data);
}
function ReadPatientParams2($array_input) {  
    global $DBtables;
    $query = "SELECT * FROM " . $DBtables['evaluationhistory'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);    
}


function getCheckparams($array_input, $tablename, $label, $enableJSON=FALSE) {  
    global $DBtables;
    $query = "SELECT CASE WHEN COUNT( * ) >0 THEN  'TRUE' ELSE  'FALSE' END AS  '" . $label ."' FROM  " . $DBtables[$tablename] . " WHERE ";
    //$query = "SELECT * FROM  " . $DBtables[$tablename] . " WHERE ";
    $query .= where_equal_value(untoken_array($array_input));
    //$query .= " LIMIT 1";
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
        $query .= " AND CONVERT(  " . set_value_list($fromdate) . ", DATE ) <= `ModDate`";
    }
    if (isset($array_input['Todate_Token'])) {
        $Todate = get_array_element_by_key_pull(untoken_array($array_input), 'Todate');
        unset($array_input['Todate_Token']);
        $query .= " AND `ModDate` < CONVERT(  " . set_value_list($Todate) . ", DATE ) ";
    }
    if (!empty($array_input)) {
        $query .= " AND `Test` IN (" . set_value_list(untoken_array($array_input)). ") ";      
    }
    $query .= "GROUP BY" . " `Test` " . " ORDER BY " . "`ModDate`" . " DESC";
    ConexionDB_JSON($query); 
}

//FIXME:added for debuggin (Ramiro)
function ReadPatientHistoryParams2 ($array_input) { 
    global $DBtables;
    ///evaluationhistory
    $query = "SELECT * FROM " . $DBtables['evaluationhistory'] . " WHERE ";
    $query .= where_like_value(untoken_array($array_input));
    ConexionDB_JSON($query);    
}


//function to add more usergroup roles to an user
function AddUserPermission($array_input, $tablename){
    
    global $DBtables;
    $justID_array=array(
        
        'UserID'=>$array_input['UserID_Token'],
        'CompanyID'=>$array_input['CompanyID_Token'],  
        //'UserGroup'=>$array_input['UserGroup_Token'],//not required     
            
    );//reading just the ID
    
    //echo "<br>justID=".print_r($justID_array); 
    
    /*
     1-send insertUser url from javascript, including  all tokens and usergroup (from InsertUserGroup)
      2-compare array from #1 with getCheckparams. If EXIT = TRUE, exit function
      3-if EXIST = False, add user
     
     */
    
    //echo "<br>Array_input=".print_r($array_input);
    //echo "<br>justID_array=".print_r($justID_array);
    
    //reading the full existent record
    $query = "SELECT * FROM ".$DBtables[$tablename]." WHERE ";
    $query .= where_equal_value(untoken_array($justID_array));
    $query .= " LIMIT 1";    
    //echo "<br>query=".$query;
    $result_check=ConexionDB_rawdata($query);
    
   
    //checking if UserID already exists
    if(empty($result_check[0])==false){
    
        //return FALSE and exit function
        echo "<br>Record already exists! nothing to do here";
        
    }else{
        
        $query2 = "SELECT * FROM ".$DBtables[$tablename]." WHERE `UserID`=".$array_input['UserID_Token']." LIMIT 1";
        //echo "<br>query2=".$query2;
        $result2 = ConexionDB_rawdata($query2);
        //echo "<br>result2=".print_r($result2);
        
        //there is existent data
        $new_record_array = array(
            
            "UserID"=>$result2[0]['UserID'],
            "PassHash"=>$result2[0]['PassHash'],
            "Forename"=>$result2[0]['Forename'],
            "MiddleName"=>$result2[0]['MiddleName'],
            "FirstSurname"=>$result2[0]['FirstSurname'],
            "SecondSurname"=>$result2[0]['SecondSurname'],
            "Email"=>$result2[0]['Email'],
            "Phone"=>$result2[0]['Phone'],
            "UserGroup"=>$array_input['UserGroup_Token'],
            "CompanyID"=>$array_input['CompanyID_Token'],
            "Status"=>$result2[0]['active'],
            "FFD"=>$result2[0]['FFD'],
        );    
        
        //echo "<br>New register=".print_r($new_register);
        InsertUsersParams($new_record_array);
        
        //FIXME: return a confirmation to user
        
    }
    //ofi
    
    
    /*
    if ($result_check[0]['EXIST'] == 'FALSE') {
        InsertGenericParams($array_input, $tablename);
        $result_validation = getCheckparams($array_input, $tablename, 'VALIDATE', TRUE);
        
        echo "<br>Inserting register";
    } else {
        print json_encode($result_check);
        echo "<br>Inserting denied";
    }
     
    */
}
//eof

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
    
    //notification
    
    
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

