<?php

include("DBArrayQuery.php");
include_once "conexionDB.php";

//store roles 
$UserGroupAsInt = array(
    "NONE" => 0,
    "guest" => 1,
    "viewer" => 2,
    "editor" => 3,
    "administrator"=>4,
    "owner"=>5,
    "developer"=>6,
    "technician"=>-1,
); 

$array = array(
    "foo" => "bar",
    "bar" => "foo",
    "ojo" => 135,
    100   => -100,
    -100  => 100,
);

//FUNCTION DEF
function SessionStart($userid){
    
    //session_name($UserID);
    session_start();
    $_SESSION["UserID"] = $userid;
    $_SESSION["Date"] = "12-21-2005";
    
    //print "<br>\nSession user=". $_SESSION["UserID"];
    //print "<br>\nSession date=". $_SESSION["Date"];    

}

function PrintSessionInfo(){
    
    //print "<br>\nSession user=". $_SESSION['UserID'];
    //print "<br>\nSession date=". $_SESSION['Date'];
    
}


function SessionDestroy(){
    
    session_start();
    session_unset();
    session_destroy();
    echo "<br> Dstroying session";
}

//function to return UserGroup numerical value for logged UserID
//returns array = [UserGroup as String][as Integer]
function ReadUserGroup($userid){
    
    global $UserGroupAsInt;
    $result = "NONE";
    $query = "SELECT UserGroup FROM Users WHERE";
    $query.= " UserID='".$userid."'";
    //echo "<br>query=".$query;
    $rawdB_result=ConexionDB_rawdata($query);//result of query
    //echo "<br>Resultado Raw=".print_r($rawdB_result);//full result
    $string_res = $rawdB_result[0]['UserGroup']; //echo "<br>Executing ReadUserGroup, string res=".$string_res;
    $int_res = $UserGroupAsInt[$string_res]; //echo "<br>Executing ReadUserGroup, int_res=".$int_res;
  
    //echo "<br>int res=".$UserGroupAsInt["Editor"];
    
    $result=array(            
        "StringUG"=> $string_res,
        "IntUG" => $int_res,
            
    );
    
    return $result;//returning UserGroup
    
}
//eof

//END OF FUNCTION DEF

//testing
//print_r ($array);
//$j='ojo';
//echo "<br>array element=".$array[$j];
//echo "<br>usergroupasint element=".$UserGroupAsInt['Editor'];
//echo "<br>usergroupasint elementx2=".$UserGroupAsInt['Editor'];
//echo "<br>";print_r ($UserGroupAsInt);
//echo "<br>result of lookup=";
//print_r (ReadUserGroup("111610820"));



?>