var fetch = angular.module('fetch', []);

	fetch.controller('dbCtrl', ['$scope', '$http', function ($scope, $http) {
		
		
		alert("Executing Eval_APP controller v1.0");
		
		//------------1. USER CONST -----------------------
		var GeneralGlobals ={};
		GeneralGlobals['DebugFlag']="NONE"; //NONE, TRUE,
		
		
		//------------2. PROGRAM VARS (DON'T TOUCH) -------
		
		//2.1 to store evaluation data from APP (Antecedentes PAtologicos)
		//tested ok
		var APPData={};
		APPData['Hypertension']="INDEFINIDO";
		APPData['Diabetes ']="INDEFINIDO";
		APPData['Cardiomyopathy']="INDEFINIDO";
		APPData['Obesity']="INDEFINIDO";
		
		//2.2 to store APNP Data (Antecedentes Mo Patologicos)
		var APNPData={};
		APNPData['Comment']="NONE";
		
		//2.3 to store AQX (Antecedentes Quirurgicos)
		var AQXData={};
		AQXData['Comment']="NONE";
		
		//2.4 to store Medicines (Medicamentos)
		var MEDData={};
		MEDData['Comment']="NONE";
		
		//2.5 to store Injuries (Lesiones)
		var INJData={};
		INJData['Comment']="NONE";
		
		//2.6 to store Physiological Variables (Variables Fisiologicas)
		var PhysioVarsData={};
		//FIXME:add data here - ask Adrian
		
		//2.7 to store Corporal Composition variables (variables de composicion corporal)
		var BodyCompData={};
		BodyCompData['Weight']="NONE";
		BodyCompData['FatMass']="NONE";
		BodyCompData['MuscleMass']="NONE";
		BodyCompData['BMI']="NONE";
		BodyCompData['FatPer']="NONE";
		BodyCompData['InBodyScore']="NONE";
		BodyCompData['BasMet']="NONE";
		BodyCompData['ViscFat']="NONE";
		BodyCompData['Flex']="NONE";
		BodyCompData['MR']="NONE";

		BodyCompData['Weight_Required']="YES";
		BodyCompData['FatMass_Required']="YES";
		BodyCompData['MuscleMass_Required']="YES";
		BodyCompData['BMI_Required']="YES";
		BodyCompData['FatPer_Required']="YES";
		BodyCompData['InBodyScore_Required']="YES";
		BodyCompData['BasMet_Required']="YES";
		BodyCompData['ViscFat_Required']="YES";
		BodyCompData['Flex_Required']="YES";
		BodyCompData['MR_Required']="YES";
		
		//2.8 to store URL vars
		var URLParams={};
		URLParams['Action']="NONE";//expected: "InsertEval"(to create new eval), "EditVal"(to edit existent eval), "DeleteVal" 
		URLParams['ID']="NONE";//expected: PatientID
		URLParams['Row_ID']="NONE";//used to edit one eval file, selected previously by RowID
		URLParams['Message']="NONE";
			
		//--------------END OF VARS ----------------------------
	
	
		//-------------3. FUNCTIONS-----------------------------
		
		
		//3.1 Resetting APP Field Values. no return
		//tested ok
		function ResetAPPFieldValues(){			
			
			APPData['Hypertension']="INDEFINIDO";
			APPData['Diabetes ']="INDEFINIDO";
			APPData['Cardiomyopathy']="INDEFINIDO";
			APPData['Obesity']="INDEFINIDO";
	
		}
		//end of function
		
		//3.2 Reseting ANPN Field values. No return		
		function ResetAPNPFieldValues(){
			
			APNPData['Comment']="NONE";			
			
		}
		//eof
		
		//3.3 Resetting AQX Field Values
		function ResetAQXFieldValues(){
			
			AQXData['Comment']="NONE";
			
		}
		//eof
		
		//3.4 Resetting Medicines Field Values. No return
		function ResetMEDFieldValues(){
			
			MEDData['Comment']="NONE";
			
		}
		//eof
		
		//3.5 Resetting Injuries Field Values. No return
		function ResetINJFieldValues(){
			
			INJData['Comment']="NONE";
			
		}
		//eof
		
		//3.6 Resetting Body Composition Field Values. No return
		function ResetBCFieldValues(){
			
			BodyCompData['Weight']="NONE";
			BodyCompData['FatMass']="NONE";
			BodyCompData['MuscleMass']="NONE";
			BodyCompData['BMI']="NONE";
			BodyCompData['FatPer']="NONE";
			BodyCompData['InBodyScore']="NONE";
			BodyCompData['BasMet']="NONE";
			BodyCompData['ViscFat']="NONE";
			BodyCompData['Flex']="NONE";
			BodyCompData['MR']="NONE";
			
		}
		
		
		//3.7 Resetting physiological Field Values. No return
		function ResetPVFieldValues(){
			
			//FIXME: add content
			
		}
		//eof
		
		//function to check parameters and store URL Params in vars
		//returns 1 if params are valid, if invalid:0	(invalid=>params are NULL, NONE or undefined)
		//tested ok		
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
		
	
		
		//2. read APP HTML elements	
		//no return
		//tested ok
		function ReadAPPData() {			
			
			//alert("(DEBUG)ReadAPPData() - starting");
						
					
			if (typeof $scope.Hyprtsn_Input_Model !== 'undefined' && $scope.Hyprtsn_Input_Model !== null && $scope.Hyprtsn_Input_Model !== "") {
				APPData['Hypertension'] = $scope.Hyprtsn_Input_Model;
			}else{
				APPData['Hypertension'] = "NONE";
			}			

			if (typeof $scope.Dbts_Input_Model !== 'undefined' && $scope.Dbts_Input_Model !== null && $scope.Dbts_Input_Model !== "") {
				APPData['Diabetes'] = $scope.Dbts_Input_Model;
			}else{
				APPData['Diabetes'] = "NONE";
			}
			
			if (typeof $scope.Crdmpthy_Input_Model !== 'undefined' && $scope.Crdmpthy_Input_Model !== null && $scope.Crdmpthy_Input_Model !== "") {
				APPData['Cardiomyopathy'] = $scope.Crdmpthy_Input_Model;
			}else{
				APPData['Cardiomyopathy'] = "NONE";
			}	
			
			if (typeof $scope.Obsty_Input_Model !== 'undefined' && $scope.Obsty_Input_Model !== null && $scope.Obsty_Input_Model !== "") {
				APPData['Obesity'] = $scope.Obsty_Input_Model;
			}else{
				APPData['Obesity'] = "NONE";
			}	
			
			
			$debug_string = "\nHypertension="+APPData['Hypertension'];
			$debug_string +="\nDiabetes="+APPData['Diabetes'] ;
			$debug_string +="\nCardiomyopathy="+APPData['Cardiomyopathy'];
			$debug_string +="\nObesity="+APPData['Obesity'];
			
			alert("(DEBUG)Function ReadAPPData() executed. Results:"+$debug_string); //(DEBUG)
			
		
		}
		//end of function

		//function to read APNP vars. No return
		function ReadAPNPData(){

			
			if (typeof $scope.APNP_Cmmnt_Input_Model !== 'undefined' && $scope.APNP_Cmmnt_Input_Model !== null && $scope.APNP_Cmmnt_Input_Model !== "") {
				APNPData['Comment'] = $scope.APNP_Cmmnt_Input_Model;
			}else{
				APNPData['Comment'] = "NONE";
			}
			
		}	
		//eof
		
		//function to read AQX vars. No return
		function ReadAQXData(){
			
			
			if (typeof $scope.AQX_Cmmnt_Input_Model !== 'undefined' && $scope.AQX_Cmmnt_Input_Model !== null && $scope.AQX_Cmmnt_Input_Model !== "") {
				AQXData['Comment'] = $scope.AQX_Cmmnt_Input_Model;
			}else{
				AQXData['Comment'] = "NONE";
			}			
			
		}
		//eof
		
		//function to read MED vars. No return		
		function ReadMEDData(){
			
			
			if (typeof $scope.MED_Cmmt_Input_Model !== 'undefined' && $scope.MED_Cmmt_Input_Model !== null) {
				MEDData['Comment'] = $scope.MED_Cmmt_Input_Model;
			}else{
				MEDData['Comment'] = "NONE";
			}	
			
			
		}
		//eof
		
		//function to read INJuries vars. No return
		function ReadINJData(){

			
			if (typeof $scope.INJ_Cmmt_Input_Model !== 'undefined' && $scope.INJ_Cmmt_Input_Model !== null) {
				INJData['Comment'] = $scope.INJ_Cmmt_Input_Model;
			}else{
				INJData['Comment'] = "NONE";
			}
					
			
		}
		//eof
		
		//function to read Body Comp vars. No return
		function ReadBCData(){
			
			
			//input text values
			
			
			if (typeof $scope.Weight_BC_Input_Model !== 'undefined' && $scope.Weight_BC_Input_Model !== null && $scope.Weight_BC_Input_Model !== "") {
				BodyCompData['Weight'] = $scope.Weight_BC_Input_Model;
			}else{
				BodyCompData['Weight'] = "NONE";
			}			
			
			
			if (typeof $scope.FatMass_BC_Input_Model !== 'undefined' && $scope.FatMass_BC_Input_Model !== null && $scope.FatMass_BC_Input_Model !== "") {
				BodyCompData['FatMass'] = $scope.FatMass_BC_Input_Model;
			}else{
				BodyCompData['FatMass'] = "NONE";
			}			
			
			
			if (typeof $scope.MuscleMass_BC_Input_Model !== 'undefined' && $scope.MuscleMass_BC_Input_Model !== null && $scope.MuscleMass_BC_Input_Model !== "") {
				BodyCompData['MuscleMass'] = $scope.MuscleMass_BC_Input_Model;
			}else{
				BodyCompData['MuscleMass'] = "NONE";
			}
			
			
			if (typeof $scope.BMI_BC_Input_Model !== 'undefined' && $scope.BMI_BC_Input_Model !== null && $scope.BMI_BC_Input_Model !== "") {
				BodyCompData['BMI'] = $scope.BMI_BC_Input_Model;
			}else{
				BodyCompData['BMI'] = "NONE";
			}

			
			if (typeof $scope.FatPer_CC_Input_Model !== 'undefined' && $scope.FatPer_CC_Input_Model !== null && $scope.FatPer_CC_Input_Model !== "") {
				BodyCompData['FatPer'] = $scope.FatPer_CC_Input_Model;
			}else{
				BodyCompData['FatPer'] = "NONE";
			}

			
			if (typeof $scope.InBodyScore_CC_Input_Model !== 'undefined' && $scope.InBodyScore_CC_Input_Model !== null && $scope.InBodyScore_CC_Input_Model !== "") {
				BodyCompData['InBodyScore'] = $scope.InBodyScore_CC_Input_Model;
			}else{
				BodyCompData['InBodyScore'] = "NONE";
			}

			if (typeof $scope.BasMet_CC_Input_Model !== 'undefined' && $scope.BasMet_CC_Input_Model !== null && $scope.BasMet_CC_Input_Model !== "") {
				BodyCompData['BasMet'] = $scope.BasMet_CC_Input_Model;
			}else{
				BodyCompData['BasMet'] = "NONE";
			}

				
			if (typeof $scope.ViscFat_CC_Input_Model !== 'undefined' && $scope.ViscFat_CC_Input_Model !== null && $scope.ViscFat_CC_Input_Model !== "") {
				BodyCompData['ViscFat'] = $scope.ViscFat_CC_Input_Model;
			}else{
				BodyCompData['ViscFat'] = "NONE";
			}

			if (typeof $scope.Flex_CC_Input_Model !== 'undefined' && $scope.Flex_CC_Input_Model !== null && $scope.Flex_CC_Input_Model !== "") {
				BodyCompData['Flex'] = $scope.Flex_CC_Input_Model;
			}else{
				BodyCompData['Flex'] = "NONE";
			}
			
			if (typeof $scope.MR_CC_Input_Model !== 'undefined' && $scope.MR_CC_Input_Model !== null && $scope.MR_CC_Input_Model !== "") {
				BodyCompData['MR'] = $scope.MR_CC_Input_Model;
			}else{
				BodyCompData['MR'] = "NONE";
			}
			
			//checkboxes
			
			
			
			
		}
		//eof
		
		//function to read Physio Vars. No return
		function ReadPVData(){
			
			
			//FIXME:add content
			/*
			if (typeof $scope. !== 'undefined' && $scope. !== null && $scope. !== "") {
				[''] = $scope.;
			}else{
				[''] = "NONE";
			}	
			*/			
		}
		//eof


		//-----APP functions ---------	
	
		//function to return APP Insert dB string
		function CreateAPPInsertString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=InsertAPP&PatientIDToken";
			URL += "&HyprtnsnToken="+APPData.Hypertension;
			URL += "&DbtsToken="+APPData.Diabetes;
			URL += "&CrdmpthyToken="+APPData.Cardiomyopathy;
			URL += "&ObstyToken="+APPData.Obesity;
			alert("(DEBUG)CreateAPPUpdateString() executed. Return URL="+URL);
			return URL;
			
		}
		//eof	

	
		//function to return APP UpdatedB string
		//tested ok
		function CreateAPPUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateAPP&RowIDToken="+URLParams.Row_ID;
			URL += "&HyprtnsnToken="+APPData.Hypertension;
			URL += "&DbtsToken="+APPData.Diabetes;
			URL += "&CrdmpthyToken="+APPData.Cardiomyopathy;
			URL += "&ObstyToken="+APPData.Obesity;
			alert("(DEBUG)CreateAPPUpdateString() executed. Return URL="+URL);
			return URL;
			
		}
		//eof
		
		//function to return APP SelectdB String
		function SelectAPPSelectString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectAPP&PatientIDToken";
			return URL;
		}
		//eof
		
		//-----APNP functions ---------	
		
		//function to return APNP Insert dB string
		function CreateAPNPInsertString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=InsertAPNP&PatientIDToken";
			URL += "&AQXCmmtToken="+APNPData.Comment;
			return URL;
		
		}
		//eof		
	
		//function to return APNP Updated dB string
		function CreateAPNPUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateAPNP&RowIDToken="+URLParams.Row_ID;
			URL += "&AQXCmmtToken="+APNPData.Comment;
			return URL;
		
		}
		//eof
		
		//function to select APNP Select dB String
		function CreateAPNPSelectString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectAPNP&PatientIDToken";
			return URL;
		}
		//eof
		
		
		//-----MED functions ---------	
		
		//function to return MED Insert dB string
		function CreateMEDInsertString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=InsertMED&PatientIDToken";
			URL += "&MedCmmtToken="+MEDData.Comment;
			return URL;
		}
		
		//function to return MED Update dB string
		function CreateMEDUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateMED&RowIDToken="+URLParams.Row_ID;
			URL += "&MedCmmtToken="+MEDData.Comment;
			return URL;
		}
		
		//function to return MED dB Select String
		function CreateMEDSelectString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectMED&PatientIDToken";
			return URL;			
		}
		//eof

		//-----INJ functions ---------
		
		//function to return INJuries Update dB string
		function CreateINJInsertString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=InsertINJ&PatientIDToken";
			URL += "&INJCmmtToken="+INJData.Comment;
			return URL;			
		}
		//eof
		
		//function to return INJuries Update dB string
		function CreateINJUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateINJ&RowIDToken="+URLParams.Row_ID;
			URL += "&INJCmmtToken="+INJData.Comment;
			return URL;			
		}
		//eof
		
		//function to return INJ Select dB String
		function CreateINJSelectString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectINJ&PatientIDToken";
			return URL;				
		}
		//eof

		//-----Physio functions ---------
		
		//function to return Physio Insert dB string
		function CreatePVUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdatePV";
			//FIXME:add content
			return URL;
		}
		//eof
		
		//function to return Physio Update dB string
		function CreatePVUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdatePV&RowIDToken="+URLParams.Row_ID;
			//FIXME:add content
			return URL;
		}
		//eof
		
		//function to return Physio Select dB string
		function CreatePVSelectString(){
			
			//FIXME:add content
			
		}
		//eof

		//-----Body composition functions ---------
		
		//function to return body Comp Insert dB string
		function CreateBodyCompInsertString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=InsertBodyComp";
			URL += "&PatientIDToken="+URLParams.ID;
			URL += "&WeightToken="+BodyCompData.Weight;
			URL += "&FatMassToken="+BodyCompData.FatMass;
			URL += "&MuscleMassToken="+BodyCompData.MuscleMass
			URL += "&BMIToken="+BodyCompData.BMI;
			URL += "&FatPerToken="+BodyCompData.FatPer;
			URL += "&InBodyScore="+BodyCompData.InBodyScore;
			URL += "&BasMetToken="+BodyCompData.BasMet;
			URL += "&ViscFatToken="+BodyCompData.ViscFat;
			URL += "&FlexToken="+BodyCompData.Flex;
			URL += "&MRToken="+BodyCompData.MR;
			alert("(DEBUG)CreateBodyCompInsertString() executed. Return URL="+URL);
			return URL;
			
		}
		//eof
		
		//function to return body Comp Update dB string
		function CreateBodyCompUpdateString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=UpdateBodyComp&RowIDToken="+URLParams.Row_ID;
			URL += "&PatientIDToken="+URLParams.ID;
			URL += "&WeightToken="+BodyCompData.Weight;
			URL += "&FatMassToken"+BodyCompData.FatMass;
			URL += "&MuscleMassToken="+BodyCompData.MuscleMass
			URL += "&BMIToken="+BodyCompData.BMI;
			URL += "&FatPerToken="+BodyCompData.FatPer;
			URL += "&InBodyScore="+BodyCompData.InBodyScore;
			URL += "&BasMet="+BodyCompData.BasMet;
			URL += "&ViscFat="+BodyCompData.ViscFat;
			URL += "&Flex="+BodyCompData.Flex;
			URL += "&MR="+BodyCompData.MR;
			alert("(DEBUG)CreateBodyCompUpdateString() executed. Return URL="+URL);
			return URL;
			
		}
		//eof
		
		//function to return Body Comp Select dB string
		function CreateBodyCompSelectString(){
			
			var URL = "../engine/dBInterface.php?ActionDBToken=SelectBodyComp&PatientIDToken";	
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

		
		
		//8. Init Function to call Main with parameter Type
		$scope.Init = function(Type) {
			Main(Type);			
		}
		
		//debug function
		$scope.dg = function(){
			alert("(DEBUG) Oh yeaaaahhh!(APP)");
			ResetAPPFieldValues();
			ReadAPPData();
			CreateAPPUpdateString();
		}
		
		//debug function for company
		$scope.dg_company = function(){
			//alert("(DEBUG) Starting Debug function(Company)");
			ReadCompanyFields();
			CreateCompanyEditString();

		}
		

		
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
