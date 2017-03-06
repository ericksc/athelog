<?php
include('../engine/session.php');
session_start();

echo "<br>Session ID=".$_SESSION['UserID'];
echo "<br>UserGRoup=";print_r (ReadUserGroup($_SESSION['UserID']));
echo "<br>UG as int=".ReadUserGroup($_SESSION['UserID'])['IntUG'];

//forcing redirect
if(ReadUserGroup($_SESSION['UserID'])['IntUG']<4){
    echo "<br>Redirigiendo a login";    
    header('Location: ' . '../index/login.html');
    
}else{
    echo "<br>Ejecutando";
    //echo file_get_contents("create_users.html");
    $pagecontents = file_get_contents("edit_users.html");
    echo str_replace("UserID_Tag", $_SESSION['UserID'], $pagecontents); 
}

?>    
