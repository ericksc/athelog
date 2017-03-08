<?php

include_once "ReadXML.php";


//VAR DEF




//END OF VAR


//FUNCT DEF

/*
$UserProfileCreatedMessage=[];$UserProfileCreatedReceivers=[];
$UserProfileDataChangedMessage=[];$UserProfileDataChangedReceivers=[];
$UserAccessDataChangedMessage=[];$UserAccessDataChangedReceivers=[];
$UserProfileFlaggedForDeletionMessage=[];$UserProfileFlaggedForDeletionReceivers=[];
$UserProfileDeletedMessage=[];$UserProfileDeletedReceivers=[];
$PatientProfileCreatedMessage=[];$PatientProfileCreatedReceivers=[];
$PatientProfileDataChangedMessage=[];$PatientProfileDataChangedReceivers=[];
$PatientProfileFlaggedForDeletionMessage=[];$PatientProfileFlaggedForDeletionReceivers=[];
$PatientProfileDeletedMessage=[];$PatientProfileDeletedReceivers=[];
$CompanyProfileCreatedMessage=[];$CompanyProfileCreatedReceivers=[];
$CompanyProfileDataChangedMessage=[];$CompanyProfileDataChangedReceivers=[];
$CompanyProfileFlaggedForDeletionMessage=[];$CompanyProfileFlaggedForDeletionReceivers=[];
$CompanyProfileDeletedMessage=[];$CompanyProfileDeletedReceivers=[]


 */

function SendMailNotification_UserProfileCreate($target_userid, $modifier){
    
    global $UserProfileCreatedReceivers;
    $CC_Receivers="";
    $BC_Receivers="";
    
    foreach($UserProfileCreatedReceivers as $key=>$val) { 
            
        if(strcmp($val,"CC")==0){
            $CC_Receivers.=$key;
        }        
        
    } 
    //end of for
    
    foreach($UserProfileDataChangedReceivers as $key=>$val) { 
            
        if(strcmp($val,"CC")==0){
            $CC_Receivers.=$key;
        }        
        
    } 
    //end of for

    
    
    //$MailDestination=
    
    //echo "UserProfile"
    
    
    
    //mail($MailDestination,$MailSubject,$MailText,$MailHeaders);
    
}

//END OF FUNCT DEF




?>