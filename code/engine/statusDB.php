<?php
include("conexionDB.php");
include("getURLparameters.php");

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

$temp = getGETarray();

print_r($temp);


}

/*
printGETarray();
print "hola\n";
parsingGETarray();
*/
/*
$temp = getGETarray();
print_r($temp);

$string1 = getQuerystatement("PatientIDToken");
print $string1;
*/



$array_parameters = getquerycomponents_array(getGETarray());
callActionFunctions('ReadCompanyquery', $array_parameters);
//$queryfunctions['ReadCompanyquery'];

//ReadGenericParameters();
?>

