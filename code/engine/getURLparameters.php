<?php
include("query_creator.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = ""; 
$where_conditions = "";
$from_table = "";
$set_value = "";
$into_table = "";
$update_table = "";

$functions = array(
  'function1' => function($echo) {
        echo $echo;
   }
);



function checkGETempty($printingconsole=FALSE){
    if (empty($_GET)) {
        if ($printingconsole) {print "URL parameters are empty";}
        return TRUE;
    }
    else{
        if ($printingconsole) {print "URL parameters are populated";}
        return FALSE;
    }
}

function printGETarray(){
    if (!checkGETempty()) {
        print_r($_GET);
    }
}
function parsingGETarray(){
    global $action, $where_conditions, $from_table, $set_value, $into_table, $update_table;
    $URLparameter_array = array();
    if (!checkGETempty()) {
        $URLparameter = $_GET;
    }
    $action = $URLparameter['ActionDBToken'];
    unset($URLparameter['ActionDBToken']);
    
    $set_value = set_key_value($URLparameter);
    global $functions;
    //print_r($action_function_array);
    call_user_func($functions['function1'], $action);

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
