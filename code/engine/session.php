<?php

//1. GLOBAL VARS
$UserName_Param="NONE";
$Password_Param="NONE";


session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_GET['UserNameToken'])) {
$UserName_Param=$_GET['UserNameToken']; 
}


if (isset($_GET['PasswordToken'])) {
$Password_Param=$_GET['PasswordToken'];
}

echo "hola";
echo "$UserName_Param";
echo "$Password_Param";
if (empty($UserName_Param) || empty($Password_Param)) {
$error = "Username or Password is invalid";
}
else
{

// Establishing Connection with Server by passing server_name, user_id and password as a parameter
//$connection = mysql_connect("localhost", "root", "");
// To protect MySQL injection for Security purpose

//$username = mysql_real_escape_string($username);
//$password = mysql_real_escape_string($password);
// Selecting Database
/*$db = mysql_select_db("company", $connection);
// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from login where password='$password' AND username='$username'", $connection);
$rows = mysql_num_rows($query);
 * */
 
if (TRUE) {
$_SESSION['login_user']=$username; // Initializing Session
header("location: search_profiles.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
//mysql_close($connection); // Closing Connection
}

?>