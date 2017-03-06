<?php

include("DBArrayQuery.php");
include ("conexionDB.php");

//store roles 
$UserGroupAsInt = array(
    "NONE" => 0,
    "Guest" => 1,
    "Viewer" => 2,
    "Editor" => 3,
    "Administrator"=>4,
    "Owner"=>5,
    "Developer"=>6,
    "Technician"=>-1,
); 

$array = array(
    "foo" => "bar",
    "bar" => "foo",
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
    
    $result = "NONE";
    $query = "SELECT UserGroup FROM Users WHERE";
    $query.= " UserID='".$userid."'";
    //echo "<br>query=".$query;
    $rawdB_result=ConexionDB_rawdata($query);//result of query
    //echo "<br>Resultado Raw=".print_r($rawdB_result);//full result
    $string_res = $rawdB_result[0]['UserGroup'];
    $int_res = $UserGroupAsInt[$string_res];
    echo "<br>int res=".$UserGroupAsInt['Editor'];
    
    $result=array(            
        "StringUG"=> $string_res,
        "IntUG" => $int_res
            
    );
    
    return $result;//returning UserGroup
    
}
//eof


//END OF FUNCTION DEF

//testing
print_r ($array);
echo "<br>";
echo "<br>usergroupasint element=".$UserGroupAsInt[0][$string_res];
echo "<br>";print_r ($UserGroupAsInt);
print_r (ReadUserGroup("111610819"));




?>