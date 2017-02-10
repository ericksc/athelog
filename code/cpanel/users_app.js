var fetch = angular.module('fetch', []);

	fetch.controller('dbCtrl', ['$scope', '$http', function ($scope, $http) {
		
		//------------1. USER CONST -----------------------
		var GeneralGlobals ={};
		GeneralGlobals['DebugFlag']="NONE"; //NONE, TRUE,
		
		
		//------------2. PROGRAM VARS (DON'T TOUCH) -------
		
		alert("(DEBUG)Welcome to users screen v1.1");
		
		//globals to hide Patient/Company text
		//FIXME:check if this is really required
		$scope.ShowPatientSection = true;
		$scope.ShowCompanySection = true;
	
		//to read values from HTML <patient> search fields
		var UserData = {};		
		UserData['UserID_FieldValue']="NONE";//
		UserData['Forename_FieldValue']="NONE";//
		UserData['FirstSurname_FieldValue']="NONE";//
		UserData['SecondSurname_FieldValue']="NONE";//
		UserData['UserPhone_FieldValue']="NONE";//
		UserData['UserEmail_FieldValue']="NONE";//
		UserData['CompanyID_FieldValue']="NONE";//
		UserData['JoinDate_FieldValue']="NONE";
		UserData['UserGroup_FieldValue']="NONE";
		UserData['Status_FieldValue']="NONE";
		
		//to read URL params var
		var URLParams = {};
		URLParams['Action'] = "NONE";
		URLParams['ID'] = "NONE";
		URLParams['Message'] = "NONE";
		
		//to set permissions - must read from Login system
		//FIXME:read from login system
		$UserID="NONE";
	
	
		//-------------2. FUNCTIONS-----------------------------
		
		//0.Resetting user values read from input text fields
		function ResetUserFieldValues(){			

			UserData.UserID_FieldValue="NONE";//
			UserData.Forename_FieldValue="NONE";//
			UserData.FirstSurname_FieldValue="NONE";//
			UserData.SecondSurname_FieldValue="NONE";//
			UserData.UserPhone_FieldValue="NONE";//
			UserData.UserEmail_FieldValue="NONE";//
			UserData.CompanyID_FieldValue="NONE";//
			UserData.JoinDate_FieldValue="NONE";
			UserData.Status_FieldValue="NONE";
			UserData.UserGroup_FieldValue="NONE";			
		};
		//end of resetting
		
		//function to check parameters
		//returns 1 if params are valid, if invalid:0	(invalid=>params are NULL, NONE or undefined)	
		function CheckURLParameters(){	

			
			//vars to read URL parameters
			URLParams.Action=getUrlVars()["Action"];
			URLParams.ID=getUrlVars()["ID"];
			URLParams.Message=getUrlVars()["Message"];

			var var1_valid=0;
			var var2_valid=0;
			var result=0;
			
			//checking if params are valid
			if (typeof URLParams.Action === 'undefined' || URLParams.Action === null || URLParams.Action === "NONE" || URLParams.Action === "") {
				//alert("(DEBUG) Action_Param = undefined,NONE or null");
				var1_valid=0;
				
			}else{
				//alert("(DEBUG) Action_Param ="+Action_Param);
				var1_valid=1;		
			}

			if (typeof URLParams.ID === 'undefined' || URLParams.ID === null || URLParams.ID === "NONE" || URLParams.ID === "") {
				//alert("(DEBUG) ID_Param = undefined, NONE or null");
				var2_valid=0;
			}else{				
				var2_valid=1;
			}
			
			//FIXME: add dB check before confirm this
			if (typeof URLParams.Message === "Updated") {
				alert("Perfil actualizado");
				
			}else{				
				
			}			
			

			//returns TRUE just if both params are different to Null, NONE, undefined or empty
			result = Boolean(var1_valid*var2_valid);
			//alert("(DEBUG)CheckURLParameters(). ID_Param="+URLParams.ID+",Action_Param="+URLParams.Action+"-Returning "+result);
			return result;
						
			
			
		}		
		//eof

		
		//2. read search HTML <user> input fields	
		//no return
		function ReadUserFields() {			
			
			//alert("(DEBUG)ReadPatientFields() - starting");
			
			if (typeof $scope.UserID_Input_Model !== 'undefined' && $scope.UserID_Input_Model !== null && $scope.UserID_Input_Model !== "") {
				UserData['UserID_FieldValue'] = $scope.UserID_Input_Model;
			}else{
				UserData['UserID_FieldValue'] = "NONE";
			}
			
			if (typeof $scope.Forename_Input_Model !== 'undefined' && $scope.Forename_Input_Model !== null && $scope.Forename_Input_Model !== "") {
				UserData['Forename_FieldValue'] = $scope.Forename_Input_Model.toLowerCase(); 				
			}else{
				UserData['Forename_FieldValue'] = "NONE";
			}
			
			if (typeof $scope.FirstSurname_Input_Model!== 'undefined' && $scope.FirstSurname_Input_Model !== null && $scope.FirstSurname_Input_Model !== "") {
				UserData['FirstSurname_FieldValue']= $scope.FirstSurname_Input_Model.toLowerCase(); 
			}else{
				UserData['FirstSurname_FieldValue'] = "NONE";
			}
			
			if (typeof $scope.SecondSurname_Input_Model !== 'undefined' && $scope.SecondSurname_Input_Model !== null && $scope.SecondSurname_Input_Model !== "") {
				UserData['SecondSurname_FieldValue'] = $scope.SecondSurname_Input_Model.toLowerCase(); 
			}else{
				UserData['SecondSurname_FieldValue'] = "NONE";
			}
			
			if (typeof $scope.UserEmail_Input_Model !== 'undefined' && $scope.UserEmail_Input_Model !== null && $scope.UserEmail_Input_Model !== "") {
				UserData['UserEmail_FieldValue'] = $scope.UserEmail_Input_Model.toLowerCase(); 
			}else{
				UserData['UserEmail_FieldValue'] = "NONE";
			}		
			
			if (typeof $scope.UserPhone_Input_Model !== 'undefined' && $scope.UserPhone_Input_Model !== null && $scope.UserPhone_Input_Model !== "") {
				UserData['UserPhone_FieldValue'] = $scope.UserPhone_Input_Model; 
			}else{
				UserData['UserPhone_FieldValue'] = "NONE";
			}				

			if (typeof $scope.CompanyID_Input_Model !== 'undefined' && $scope.CompanyID_Input_Model !== null && $scope.CompanyID_Input_Model !== "") {
				UserData['CompanyID_FieldValue'] = $scope.CompanyID_Input_Model.toLowerCase();  
			}else{
				UserData['CompanyID_FieldValue'] = "NONE";
			}			
			
			if (typeof $scope.UserGroupSelect_Input_Model !== 'undefined' && $scope.UserGroupSelect_Input_Model !== null && $scope.UserGroupSelect_Input_Model !== "") {
				UserData['UserGroup_FieldValue'] = $scope.UserGroupSelect_Input_Model.toLowerCase();  
			}else{
				UserData['UserGroup_FieldValue'] = "NONE";
			}				
			
			if (typeof $scope.Status_Input_Model !== 'undefined' && $scope.Status_Input_Model !== null && $scope.Status_Input_Model !== "") {
				UserData['Status_FieldValue'] = $scope.Status_Input_Model.toLowerCase();  
			}else{
				UserData['Status_FieldValue'] = "NONE";
			}				
			
			
			$debug_string = "\nUserID_FieldValue="+UserData['UserID_FieldValue'];
			$debug_string +="\nForename_FieldValue="+UserData['Forename_FieldValue'];
			$debug_string +="\nFirstSurname_FieldValue="+UserData['FirstSurname_FieldValue'];
			$debug_string +="\nSecondSurname_FieldValue="+UserData['SecondSurname_FieldValue'];
			$debug_string +="\nUserEmail_FieldValue="+UserData['UserEmail_FieldValue'];
			$debug_string +="\nUserPhone_FieldValue="+UserData['UserPhone_FieldValue'];
			$debug_string +="\nCompanyID_FieldValue="+UserData['CompanyID_FieldValue'];
			$debug_string +="\nUserGroup_FieldValue="+UserData['UserGroup_FieldValue'];			
			$debug_string +="\nStatus_FieldValue="+UserData['Status_FieldValue'];		
			
			alert("(DEBUG)Function ReadUserFields() executed. Results:"+$debug_string); //(DEBUG)
			
		
		}
		//end of function
		
		
		//function to return user search string, based on patient inout fields
		function CreateUserSearchString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectUser";
		
			if(UserData.UserID_FieldValue !=="NONE"){
				URL+="&UserIDToken="+UserData.UserID_FieldValue;
			}

			if(UserData.Forename_FieldValue !=="NONE"){
				URL+="&ForenameToken="+UserData.Forename_FieldValue;
			}

			if(UserData.FirstSurname_FieldValue !=="NONE"){
				URL+="&FirstSurnameToken="+UserData.FirstSurname_FieldValue;
			}

			if(UserData.SecondSurname_FieldValue !=="NONE"){
				URL+="&SecondSurnameToken="+UserData.SecondSurname_FieldValue;
			}

			if(UserData.UserPhone_FieldValue !=="NONE"){
				URL+="&PhoneToken="+UserData.UserPhone_FieldValue;
			}

			if(UserData.UserEmail_FieldValue !=="NONE"){
				URL+="&EmailToken="+UserData.PatientEmail_FieldValue;
			}

			if(UserData.CompanyID_FieldValue !=="NONE"){
				URL+="&CompanyIDToken="+UserData.CompanyID_FieldValue;
			}
			
			if(UserData.Status_FieldValue !=="NONE"){
				URL+="&StatusToken="+UserData.Status_FieldValue;
			}

			if(UserData.UserGroup_FieldValue !=="NONE"){
				URL+="&UserGroupToken="+UserData.UserGroup_FieldValue;
			}
			
			alert("(DEBUG)CreateUserSearchString()-ending.URL="+URL);
			return URL;
			
		}
		//eof
		
		//function to return string to delete patient, by patient ID (taken from URL)
		function CreateUserDeleteStringByID(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=DeleteUser";
			URL+="&UserIDToken="+URLParams.ID;
			//alert("(DEBUG)CreateUserDeleteStringByID() executed. Return URL="+URL);
			return URL;
			
		}
		//eof

		//function to generate URL string to insert patient into dB
		//returns the URL
		function CreateUserInsertString(){
			
			//alert("(DEBUG)CreateUserInsertString()-starting");			
			var URL = "../engine/dBInterface.php?";
			URL += "ActionDBToken=InsertUser";
			URL += "&UserIDToken="+UserData.UserID_FieldValue;
			URL += "&ForenameToken="+UserData.Forename_FieldValue;
			URL += "&FirstSurnameToken="+UserData.FirstSurname_FieldValue;
			URL += "&SecondSurnameToken="+UserData.SecondSurname_FieldValue;
			URL += "&EmailToken="+UserData.UserEmail_FieldValue;
			URL += "&PhoneToken="+UserData.UserPhone_FieldValue;
			URL += "&CompanyIDToken="+UserData.CompanyID_FieldValue;
			URL += "&UserGroupToken="+UserData.UserGroup_FieldValue;
			URL += "&StatusToken="+UserData.Status_FieldValue;
						
			//alert("(DEBUG)CreateUserInsertString()-ending.URL="+URL);
			return URL;
			
		}
		//eof
		
		//function to return the URL string to update user profile data
		//it uses URLParams.ID global to select user
		function CreateUserEditString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateEdit";
			URL+="&UserIDToken="+URLParams.ID;

			if(UserData.Forename_FieldValue !=="NONE"){
				URL+="&ForenameToken="+UserData.Forename_FieldValue;
			}

			if(UserData.FirstSurname_FieldValue !=="NONE"){
				URL+="&FirstSurnameToken="+UserData.FirstSurname_FieldValue;
			}

			if(UserData.SecondSurname_FieldValue !=="NONE"){
				URL+="&SecondSurnameToken="+UserData.SecondSurname_FieldValue;
			}

			if(UserData.UserPhone_FieldValue !=="NONE"){
				URL+="&PhoneToken="+UserData.UserPhone_FieldValue;
			}

			if(UserData.UserEmail_FieldValue !=="NONE"){
				URL+="&EmailToken="+UserData.UserEmail_FieldValue;
			}

			if(UserData.CompanyID_FieldValue !=="NONE"){
				URL+="&CompanyIDToken="+UserData.CompanyID_FieldValue;
			}

			if(UserData.UserGroup !=="NONE"){
				URL+="&UserGroupToken="+UserData.UserGroup;
			}			
			
			if(UserData.Status !=="NONE"){
				URL+="&StatusToken="+UserData.Status;
			}			

			//alert("(DEBUG)CreatePatientEditString()-ending.URL="+URL);
			return URL;
			
		}
		//eof

	
	
		//validating input field to prevent the user to enter invalid words or chars
		//returns true is field value is valid
		//forbidden substring: ADD, ALTER, AND, CREATE, DELETE, DROP,  EXISTS, IF, INSERT, LIKE, OR, SELECT, UNION, UPDATE, WHERE
 		//forbidden characters: <>@¡!#$%^&*()_+[]{}¿?:;|'\"\\,./~`¨-=ñáéúóíàèìòùäëïöüâêîôû
		function CheckInputField(field_value,field_type){			
		
			//alert("(DEBUG)CheckInputField() - executing on value="+field_value+", type="+field_type);
			
			var specialChars = "<>@¡!#$%¬^&*()_+[]{}¿?:;|'\"\\,./~`¨-=ñáéúóíàèìòùäëïöüâêîôû";//default
			
			if(field_type=="email"){
				specialChars = "<>¡!#$%¬^&*()+[]{}¿?:;|'\"\\,/~`¨=ñáéúóíàèìòùäëïöüâêîôû";
			}else if(field_type=="date"){
				specialChars = "<>@¡!#$%¬^&*()_+[]{}¿?:;|'\"\\,.~`¨=ñáéúóíàèìòùäëïöüâêîôû";
			}else{
				specialChars = "<>@¡!#$%¬^&*()_+[]{}¿?:;|'\"\\,./~`¨-=ñáéúóíàèìòùäëïöüâêîôû";
			}
			
			//var temp = $scope[field_value]; 
			var temp = field_value;
			//alert("(DEBUG)CheckInputField() - looking for forbidden words="+temp);
			

				//looking for fobidden words
				if(temp.indexOf('add')!=-1){
					return false;
					//alert("(DEBUG)CheckInputField() - looking for <add>")		
				}else if(temp.indexOf('alter ')!=-1){
					return false;
				}else if(temp.indexOf(' and ')!=-1){
					return false;				
				}else if(temp.indexOf('create ')!=-1){
					return false;
				}else if(temp.indexOf('delete ')!=-1){
					return false;
				}else if(temp.indexOf('drop ')!=-1){
					return false;
				}else if(temp.indexOf('exist ')!=-1){
					return false;
				}else if(temp.indexOf('if ')!=-1){
					return false;
				}else if(temp.indexOf('insert ')!=-1){
					return false;
				}else if(temp.indexOf('like ')!=-1){
					return false;
				}else if(temp.indexOf(' or ')!=-1){
					return false;
				}else if(temp.indexOf('select ')!=-1){
					return false;
				}else if(temp.indexOf('union ')!=-1){
					return false;
				}else if(temp.indexOf('update ')!=-1){
					return false;
				}else if(temp.indexOf('where ')!=-1){
					return false;
				}else if(temp.indexOf(' ')!=-1){
					return false;			
				}else{ 
					//looking for forbidden chars
					//alert("(DEBUG)CheckInputField() - looking for forbidden chars");
					for(i = 0; i < specialChars.length;i++){
							if(temp.indexOf(specialChars[i]) > -1){
								//alert("(DEBUG)CheckInputField()-detecting invalid char="+specialChars[i]+".Returning FALSE");
								return false;
							}
					}
					//alert("(DEBUG)CheckInputField()-executed. Returning TRUE");	
					return true;
				}

		} 
		//eof

		//FIXME: convert for user
		//function to validate patient input data in HTML fields
		//returns true if everything is valid, otherwise false
		function CheckPatientInputData(){	
			
			//alert("(DEBUG)CheckPatientInputData() - starting"  );
			
			if(CheckInputField(PatientData.Forename_FieldValue,"text")==false){
				//alert("ERROR - Entrada invalida en Nombre");
				return false;
			}else if(CheckInputField(PatientData.FirstSurname_FieldValue,"text")==false){
				//alert("ERROR - Entrada invalida en Primer Apellido");
				return false;
			}else if(CheckInputField(PatientData.SecondSurname_FieldValue,"text")==false){
				//alert("ERROR - Entrada invalida en Segundo Apellido");
				return false;
			}else if(CheckInputField(PatientData.PatientEmail_FieldValue,"email")==false){
				//alert("ERROR - Entrada invalida en Email");
				return false;
			}else if(1==10){
			//	//alert("ERROR - Entrada invalida en telefono");
			//FIXME: script failing when checking the phone number	
				return false;
			}else{
				//alert("(DEBUG)CheckPatientInputData() - ending. Return TRUE"  );
				return true;				
			}
			
		}
		//eof

			
		//2. Create <user> Search string, by ID arg (taken from URL "ID" arg)
		// returns URL string
		function CreateUserSearchStringByID () {
			
			var URLstring = "../engine/dBInterface.php?ActionDBToken=SelectUser";
			URLstring+="&UserIDToken="+URLParams.ID;
			//alert("(DEBUG)CreateUserSearchStringByID() - User Search String="+URLstring);
			return URLstring;
			
		};
		//end of function	
		
		//function to search patient by ID, Surname, Forename, Company, etc
		//intended to be called from HTML
		$scope.SearchUser = function(){
			
			//alert ("(DEBUG)-SearchPatient() - starting");
			ResetUserFieldValues();
			ReadUserFields();		
			CallPHPServerFile(CreateUserSearchString());
			//alert ("(DEBUG)-SearchPatient() - executed");			
		}
		//eof
		
		//FIXME: convert to user
		//general function to introduce a new patient in dB	
		$scope.CreatePatient = function() {			
			
			//alert ("(DEBUG)-CreatePatient() - starting");
			ReadPatientFields();		
			
			if (CheckPatientInputData()==true){
				//alert("(DEBUG)CreatePatient()-Input data is right");
				CallPHPServerFile(CreatePatientInsertString());
			}else{
				//alert("ERROR - datos invalidos");				
			}
			//alert ("(DEBUG)-CreatePatient() - executed");
		}
		//eof	

		//FIXME: convert to user 	
		//function to store updated company into dB
		$scope.EditPatient = function(){
			
			//alert("(DEBUG) EditPatient() - starting");
			ReadPatientFields();			
			CallPHPServerFile(CreatePatientEditString());			
		}
		//eof
		
		//FIXME: convert to user
		//function to delete patient. Intended to be called from HTML page
		//no return
		$scope.DeletePatient = function(){
			
			//alert("(DEBUG)DeletePatient() - starting");
			CallPHPServerFile(CreatePatientDeleteStringByID());
			//alert("(DEBUG)DeletePatient() - executed");
		}
		//eof
		
	

		/*5. Function to read vars from URL string
		intended to get "Action" and "ID" for patients and companies
		Its called this way:		var first = getUrlVars()["Action"]; var second = getUrlVars()["ID"];*/
		function getUrlVars() {
			
			
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
			});
			return vars;
			
		}
		

		
		//7. Function to call php server file, in $address
		//FIXME: add the .error part
		function CallPHPServerFile(URLstring) {			
			
			
			//alert("(DEBUG)Function CallPHPServerFile() calling"); //(DEBUG)			
			$http.get(URLstring)
			.success(function(data){
			$scope.data = data;
			})
			
			//alert("(DEBUG)Function CallPHPServerFile() executed"); //(DEBUG)

		}
		//eof
		
				//FIXME: convert to user
		//8. Function to check if Patient has been succesfully created into database
		//returns TRUE if patient do exists
		function CheckIfPatientExists(){
			
			
			return true;
		}
		//eof
		
		//8. Init Function to call Main with parameter Type
		$scope.Init = function(Type) {
			Main(Type);			
		}
		
		
		//debug function
		$scope.dg = function(){
			//alert("(DEBUG) Oh yeaaaahhh!(Patient)");
			
			ReadPatientFields();
			CreatePatientInsertString();
			//CreatePatientDeleteStringByID();
			
			
			//CheckURLParameters();
			//CallPHPServerFile(CreatePatientSearchStringByURL());
			
			//ReadPatientFields();
			//CheckInputField(PatientData.Forename_FieldValue,"text");
			//CheckPatientInputData();
			/*
			ResetVars();
			ReadPatientFields();
			CreatePatientInsertString();
			CheckPatientInputFields();
			*/
		}
		
		//debug function for company
		$scope.dg_company = function(){
			//alert("(DEBUG) Starting Debug function(Company)");
			ReadCompanyFields();
			CreateCompanyEditString();
			
			//CheckURLParameters();
			//CallPHPServerFile(CreateCompanySearchStringByURL());
						
			/*
			ReadCompanyFields();
			CheckCompanyInputData();
			CreateCompanyInsertString();
			*/
			
			//alert("(DEBUG)  Ending Debug function(Company)");

		}
		

		//FIXME: convert to user
		//9. MAIN function to execute scripts
		// Arg Type="Patient" or "Company". Its set by HTML controller tag
		// return true if succesfully executed
		function Main (Type) {	
			
			//alert("(DEBUG)Main()-starting with Type="+Type);
			
			//check parameters
			if(CheckURLParameters()==true){
				
				if(Type=='Patient' && URLParams.Action=="EditPatient"){
					
					CallPHPServerFile(CreatePatientSearchStringByID());
					return true;
				}
				else if (Type=='Company' && URLParams.Action=="EditCompany"){
					
					CallPHPServerFile(CreateCompanySearchStringByID());
					return true;
				}
				else{
					//ActionParam is undefined
					//alert("(DEBUG)Main - Finishing Main without search");
					return false;
				}
				
				
				
			}else{
				//failed the URL args validation
				return false;
			}
					
			
		} 	
		
	
	//---------------END OF FUNCT DEF-------------------------
	
	//---------------Executing Script
	//Main('Patient');
	
	
	}]);
