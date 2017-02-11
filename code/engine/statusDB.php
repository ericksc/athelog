<?php
include("conexionDB.php");

define('DBversion','SELECT VERSION( )');
$query = "NONE";

function ReadGenericParameters(){
	
	global $ActionDB_Param;
	
	
	if (isset($_GET['ActionDBToken'])) {
		$ActionDB_Param=$_GET['ActionDBToken'];
		
		if($ActionDB_Param=="DBversion"){
			DBversionParams(); //Creating Patient Select Query String
		}
        }
}

function DBversionParams() {
		
global $query;
$query = DBversion;
ConexionDB_JSON($query);
$value = ConexionDBResult_NumRowAfected($query);
print "\nReturn value:";
print $value;
print "\n";

ConexionDBResult_PrintArray($query);


print_r(ConexionDB_rawdata($query));


}

ReadGenericParameters();
?>

