<?php

//0. CONST

//base queries
define('SelectPatient_BasicQuery', 'SELECT * from Patients WHERE 1');
define('SelectCompany_BasicQuery', 'SELECT * from Companies WHERE 1');
define('InsertPatient_BasicQuery', 'INSERT INTO Patients');
define('InsertCompany_BasicQuery', 'INSERT INTO Companies');
define('DeletePatient_BasicQuery', 'DELETE FROM Patients WHERE 1');
define('DeleteCompany_BasicQuery', 'DELETE FROM Companies WHERE 1');
define('UpdatePatient_BasicQuery', 'UPDATE `Patients` SET ');
define('UpdateCompany_BasicQuery', 'UPDATE `Companies` SET ');
define('LoginUser_BasicQuery', 'SELECT `Users` ');
// TODO: define base queries for the other operations

//1. GLOBAL VARS
$ActionDB_Param="NONE";
$UserID_Param="NONE";
$DebugFlag="FALSE";

//$query = "SELECT * from Patients WHERE 1"; //working
$query = "NONE"; //working


//2. FUNCT DEF
// TODO: create more functions for other operations 
// TODO: add more actionDB_Param for other operations
//

//function to read generic parameters
//capture URL params $ActionDB_Param and $UserID_Param
function ReadGenericParameters(){
	
	global $ActionDB_Param, $UserID_Param, $DebugFlag;
	
	
	if (isset($_GET['ActionDBToken'])) {
		$ActionDB_Param=$_GET['ActionDBToken'];
		
		if($ActionDB_Param=="SelectPatient"){
			ReadPatientParams(); //Creating Patient Select Query String
		}
		else if($ActionDB_Param=="SelectCompany"){
			ReadCompanyParams(); //Creating Company Select Query String
		}
		else if($ActionDB_Param=="InsertPatient"){
			InsertPatientParams(); //Creating Patient INSERT INTO Query String
		}
		else if($ActionDB_Param=="DeletePatient"){
			DeletePatientParams(); //Creating Patient DELETE INTO Query String
		}
		else if($ActionDB_Param=="DeleteCompany"){
			DeleteCompanyParams(); //Creating Patient DELETE INTO Query String
		}
                else if($ActionDB_Param=="InsertCompany"){
			InsertCompanyParams(); //Creating Patient INSERT INTO Query String
		}
                else if($ActionDB_Param=="UpdatePatient"){
			UpdatePatientParams(); //Updating Patient UPDATE INTO Query String
		}
                else if($ActionDB_Param=="UpdateCompany"){
			UpdateCompanyParams(); //Updating Company UPDATE INTO Query String
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

//function to delete patient:
function DeletePatientParams() {
		
	global $query;
	$query = DeletePatient_BasicQuery;

	if (isset($_GET['PatientIDToken'])) {
		$PatientID_Param=$_GET['PatientIDToken'];
		
		if($PatientID_Param!="NONE"){
			$query .= " AND PatientID LIKE $PatientID_Param";				
		}
	}
}

//function to delete company:
function DeleteCompanyParams() {
		
	global $query;
	$query = DeleteCompany_BasicQuery;

	if (isset($_GET['CompanyIDToken'])) {
		$CompanyID_Param=$_GET['CompanyIDToken'];
		
		if($CompanyID_Param!="NONE"){
			$query .= " AND CompanyID LIKE $CompanyID_Param";				
		}
	}
}

//function to insert params related to patient:
function InsertPatientParams() {   //define('InsertPatient_BasicQuery', 'INSERT INTO');
		
	global $query;
	$query = InsertPatient_BasicQuery;
	$ColumnList = " (PatientID,Forename,FirstSurname,SecondSurname,Email,CompanyID)";
	$query .= $ColumnList;
	$ValuesList = " VALUES (";

	if (isset($_GET['PatientIDToken'])) {
		$PatientID_Param=$_GET['PatientIDToken'];
		
		if($PatientID_Param!="NONE"){
			$ValuesList .= "'$PatientID_Param',";				
		}
	}

	if (isset($_GET['ForenameToken'])) {
		$Forename_Param=$_GET['ForenameToken'];

		if($Forename_Param!="NONE"){
			$ValuesList .= "'$Forename_Param',";				
		}
		
	}	

	if (isset($_GET['FirstSurnameToken'])) {
		$FirstSurname_Param=$_GET['FirstSurnameToken'];
		
		if($FirstSurname_Param!="NONE"){
			$ValuesList .= "'$FirstSurname_Param',";				
		}
		
	}	

	if (isset($_GET['SecondSurnameToken'])) {
		$SecondSurname_Param=$_GET['SecondSurnameToken'];
		
		if($SecondSurname_Param!="NONE"){
			$ValuesList .= "'$SecondSurname_Param',";				
		}	
		
	}

	if (isset($_GET['EmailToken'])) {
		$Email_Param=$_GET['EmailToken'];
		
		if($Email_Param!="NONE"){
			$ValuesList .= "'$Email_Param',";				
		}		
		 
		
	}	

	
	if (isset($_GET['CompanyIDToken'])) {
		$Company_Param=$_GET['CompanyIDToken'];
		
		if($Company_Param!="NONE"){
			$ValuesList .= "'$Company_Param')";				
		}	
		
	}
	$query .= $ValuesList;


}
//function to insert params related to Company:
function InsertCompanyParams() {   //define('InsertCompany_BasicQuery', 'INSERT INTO');
		
	global $query;
	$query = InsertCompany_BasicQuery;
	$ColumnList = " (CompanyID,Phone,Email,Address)";
	$query .= $ColumnList;
	$ValuesList = " VALUES (";

	if (isset($_GET['CompanyIDToken'])) {
		$CompanyID_Param=$_GET['CompanyIDToken'];
		
		if($CompanyID_Param!="NONE"){
			$ValuesList .= "'$CompanyID_Param',";				
		}
	}

	if (isset($_GET['PhoneToken'])) {
		$Phone_Param=$_GET['PhoneToken'];

		if($Phone_Param!="NONE"){
			$ValuesList .= "'$Phone_Param',";				
		}
		
	}	

	if (isset($_GET['EmailToken'])) {
		$Email_Param=$_GET['EmailToken'];
		
		if($Email_Param!="NONE"){
			$ValuesList .= "'$Email_Param',";				
		}
		
	}	

	if (isset($_GET['AddressToken'])) {
		$Address_Param=$_GET['AddressToken'];
		
		if($Address_Param!="NONE"){
			$ValuesList .= "'$Address_Param')";				
		}	
		
	}
	$query .= $ValuesList;


}
// TODO: add other function definitions for the sql operations. Starting with single insert
//eof
//
//function to Update params related to patient:
function UpdatePatientParams() {   //define('UpdatePatient_BasicQuery', 'UPDATE');
		
	global $query;
	$query = UpdatePatient_BasicQuery;

	if (isset($_GET['ForenameToken'])) {
		$Forename_Param=$_GET['ForenameToken'];
		
		if($Forename_Param!="NONE"){
			$query .= "`Forename` = '$Forename_Param', ";				
		}
	}

	if (isset($_GET['FirstSurnameToken'])) {
		$FirstSurname_Param=$_GET['FirstSurnameToken'];

		if($FirstSurname_Param!="NONE"){
			$query .= "`FirstSurname` = '$FirstSurname_Param', ";			
		}
		
	}	

	if (isset($_GET['SecondSurnameToken'])) {
		$SecondSurname_Param=$_GET['SecondSurnameToken'];

		if($SecondSurname_Param!="NONE"){
			$query .= "`SecondSurname` = '$SecondSurname_Param', ";			
		}
		
	}

	if (isset($_GET['EmailToken'])) {
		$Email_Param=$_GET['EmailToken'];

		if($Email_Param!="NONE"){
			$query .= "`Email` = '$Email_Param', ";			
		}
		
	}	

	if (isset($_GET['PhoneToken'])) {
		$Phone_Param=$_GET['PhoneToken'];

		if($Phone_Param!="NONE"){
			$query .= "`Phone` = '$Phone_Param', ";			
		}
		
	}
	
	if (isset($_GET['BirthDateToken'])) {
		$BirthDate_Param=$_GET['BirthDateToken'];

		if($BirthDate_Param!="NONE"){
			$query .= "`BirthDate` = '$BirthDate_Param', ";			
		}
		
	}
		
	if (isset($_GET['GenderToken'])) {
		$Gender_Param=$_GET['GenderToken'];

		if($Gender_Param!="NONE"){
			$query .= "`Gender` = '$Gender_Param', ";			
		}
		
	}
	
	if (isset($_GET['AddressToken'])) {
		$Address_Param=$_GET['AddressToken'];

		if($Address_Param!="NONE"){
			$query .= "`Address` = '$Address_Param', ";			
		}
		
	}
	
	if (isset($_GET['DepartmentToken'])) {
		$Department_Param=$_GET['DepartmentToken'];

		if($Department_Param!="NONE"){
			$query .= "`Department` = '$Department_Param', ";			
		}
		
	}
	
	if (isset($_GET['SiteToken'])) {
		$Site_Param=$_GET['SiteToken'];

		if($Site_Param!="NONE"){
			$query .= "`Site` = '$Site_Param' ";			
		}
		
	}					

	if (isset($_GET['PatientIDToken'])) {
		$PatientID_Param=$_GET['PatientIDToken'];

		if($PatientID_Param!="NONE"){
			$query .= " WHERE `PatientID` = '$PatientID_Param'";			
		}
		
	}	


}

//function to Update params related to patient:
function UpdateCompanyParams() {   //define('UpdateCompany_BasicQuery', 'UPDATE');
		
	global $query;
	$query = UpdateCompany_BasicQuery;

	if (isset($_GET['PhoneToken'])) {
		$Phone_Param=$_GET['PhoneToken'];
		
		if($Phone_Param!="NONE"){
			$query .= "`Phone` = '$Phone_Param', ";				
		}
	}

	if (isset($_GET['EmailToken'])) {
		$Email_Param=$_GET['EmailToken'];

		if($Email_Param!="NONE"){
			$query .= "`Email` = '$Email_Param', ";			
		}
		
	}	

	if (isset($_GET['AddressToken'])) {
		$Address_Param=$_GET['AddressToken'];

		if($Address_Param!="NONE"){
			$query .= "`Address` = '$Address_Param' ";			
		}
		
	}

	if (isset($_GET['CompanyIDToken'])) {
		$CompanyID_Param=$_GET['CompanyIDToken'];

		if($CompanyID_Param!="NONE"){
			$query .= " WHERE `CompanyID` = '$CompanyID_Param'";			
		}
		
	}
}

//function to login user:
function LoginUserParams() {
		
	global $query;
	$query = DeletePatient_BasicQuery;

	if (isset($_GET['PatientIDToken'])) {
		$PatientID_Param=$_GET['PatientIDToken'];
		
		if($PatientID_Param!="NONE"){
			$query .= " AND PatientID LIKE $PatientID_Param";				
		}
	}
}
function Main(){
	
	global $query;
	
       
	ReadGenericParameters();	
	
	// $connect = mysqli_connect("mysql.hostinger.es","u505969032_ramvq","joliewatt0123","u505969032_bicoy");
	$connect = mysqli_connect("mysql.hostinger.es","u884088163_erix","L4rd_erix","u884088163_irixs");
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