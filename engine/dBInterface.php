<?php

//0. CONST

//base queries
define('SelectPatient_BasicQuery', 'SELECT * from Patients WHERE 1');
define('SelectCompany_BasicQuery', 'SELECT * from Companies WHERE 1');


//1. GLOBAL VARS
$ActionDB_Param="NONE";
$UserID_Param="NONE";

//$query = "SELECT * from Patients WHERE 1"; //working
$query = "NONE"; //working


//2. FUNCT DEF

//function to read generic parameters
//capture URL params $ActionDB_Param and $UserID_Param
function ReadGenericParameters(){
	
	global $ActionDB_Param, $UserID_Param;
	
	
	if (isset($_GET['ActionDBToken'])) {
		$ActionDB_Param=$_GET['ActionDBToken'];
		
		if($ActionDB_Param=="SelectPatient"){
			ReadPatientParams(); //Creating Patient Select Query String
		}
		else if($ActionDB_Param=="SelectCompany"){
			ReadCompanyParams(); //Creating Company Select Query String
		}
		
	}

	if (isset($_GET['UserIDToken'])) {
		$UserID_Param=$_GET['UserIDToken'];
	}

	if($DebugFlag=="TRUE"){	
		echo "<br>(DEBUG)Param ActionDB_Param=$ActionDB_Param. Param UserID_Param=$UserID_Param";
	} 

}
//eof

//function to Read Company Params
function ReadCompanyParams() {

	global $query;
	$query = SelectCompany_BasicQuery;

	if (isset($_GET['CompanyID2Token'])) {
		$CompanyID2_Param=$_GET['CompanyID2Token'];
		
		if($CompanyID2_Param!="NONE"){
			$query .= " AND CompanyID LIKE '$CompanyID2_Param'";				
		}
		
	}

	if (isset($_GET['CompanyEmailToken'])) {
		$CompanyEmail_Param=$_GET['CompanyEmailToken'];

		if($CompanyEmail_Param!="NONE"){
			$query .= " AND Email LIKE '$CompanyEmail_Param'";				
		}
		
	}	

	if (isset($_GET['CompanyPhoneToken'])) {
		$CompanyPhone_Param=$_GET['CompanyPhoneToken'];

		if($CompanyPhone_Param!="NONE"){
			$query .= " AND Phone LIKE '$CompanyPhone_Param'";				
		}
		
	}	
}
//end of function to Read Company Params


//function to read params related to patient:
function ReadPatientParams() {
		
	global $query;
	$query = SelectPatient_BasicQuery;

	if (isset($_GET['PatientIDToken'])) {
		$PatientID_Param=$_GET['PatientIDToken'];
		
		if($PatientID_Param!="NONE"){
			$query .= " AND PatientID LIKE $PatientID_Param";				
		}
	}

	if (isset($_GET['ForenameToken'])) {
		$Forename_Param=$_GET['ForenameToken'];

		if($Forename_Param!="NONE"){
			$query .= " AND Forename LIKE '$Forename_Param'";				
		}
		
	}	

	if (isset($_GET['FirstSurnameToken'])) {
		$FirstSurname_Param=$_GET['FirstSurnameToken'];
		
		if($FirstSurname_Param!="NONE"){
			$query .= " AND FirstSurname LIKE '$FirstSurname_Param'";				
		}
		
	}	

	if (isset($_GET['SecondSurnameToken'])) {
		$SecondSurname_Param=$_GET['SecondSurnameToken'];
		
		if($SecondSurname_Param!="NONE"){
			$query .= " AND SecondSurname LIKE '$SecondSurname_Param'";				
		}	
		
	}

	if (isset($_GET['EmailToken'])) {
		$Email_Param=$_GET['EmailToken'];
		
		if($Email_Param!="NONE"){
			$query .= " AND Email LIKE '$Email_Param'";				
		}		
		
		
	}	

	if (isset($_GET['CompanyToken'])) {
		$Company_Param=$_GET['CompanyToken'];
		
		if($Company_Param!="NONE"){
			$query .= " AND Company LIKE '$Company_Param'";				
		}	
		
	}		

}
//eof

function Main(){
	
	global $query;
	
	ReadGenericParameters();
	//ReadCompanyParams();	
	//ReadPatientParams();
	
	$connect = mysqli_connect("mysql.hostinger.es","u910477891_ramvq","joliewatt0123","u910477891_bicoy");
	$result = mysqli_query($connect,$query);
	
	$data = array();

	while ($row = mysqli_fetch_array($result)) {
	  $data[] = $row;
	}
    print json_encode($data);
}
//eof

//END OF FUNCT DEF






//--3. Executing script
Main();



?>