<?php

include "ReadXML.php";


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
    
    echo "<br><br>Executing SendMailNotification_UserProfileCreate";
    
    global $UserProfileCreatedReceivers;
    global $TechnicianMailAccounts;
    global $DeveloperMailAccounts;
    global $OwnerMailAccounts;
    
    $CC_Receivers="";
    $BC_Receivers="";
    $TO_Receivers=$target_userid;
    
    echo "<br>UserProfileCreatedReceivers="; print_r ($UserProfileCreatedReceivers);
    echo "<br>TechnicianMailAccounts=".$TechnicianMailAccounts;
    
    foreach($UserProfileCreatedReceivers as $key=>$val) { 
        
        echo "<br>Checking settings for $key";
        
        if(strcmp($key,"Technician")==0){
            
            if(strcmp($val,"CC")==0)$CC_Receivers.=$TechnicianMailAccounts;
            else if(strcmp($val,"BC")==0)$BC_Receivers.=$TechnicianMailAccounts;
            else if(strcmp($val,"TO")==0)$TO_Receivers.=$TechnicianMailAccounts.",";
            
        }else if(strcmp($key,"Developer")==0){

            if(strcmp($val,"CC")==0)$CC_Receivers.=$DeveloperMailAccounts;
            else if(strcmp($val,"BC")==0)$BC_Receivers.=$DeveloperMailAccounts;
            else if(strcmp($val,"TO")==0)$TO_Receivers.=$DeveloperMailAccounts.",";            
            
        }else if(strcmp($key,"Owner")==0){
            
            if(strcmp($val,"CC")==0)$CC_Receivers.=$OwnerMailAccounts;
            else if(strcmp($val,"BC")==0)$BC_Receivers.=$OwnerMailAccounts;
            else if(strcmp($val,"TO")==0)$TO_Receivers.=$OwnerMailAccounts.","; 
        }
        

    } 
    //end of for
    
    //echo "<br><br>SendMailNotification_UserProfileCreate:";
   // echo "<br>CC_Receivers=.$CC_Receivers";
    //echo "<br>BC_Receivers=".$BC_Receivers;
    //echo "<br>TO_Receivers=".$TO_Receivers;
    
    
    //$MailDestination=
    
    //echo "UserProfile"
    
    
    
    //mail($MailDestination,$MailSubject,$MailText,$MailHeaders);
    
}

//END OF FUNCT DEF

SendMailNotification_UserProfileCreate("aa","gg");


?>