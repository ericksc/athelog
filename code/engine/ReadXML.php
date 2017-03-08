<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//global vars

$xml="";//xml file

//global arrays for mail
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
$CompanyProfileDeletedMessage=[];$CompanyProfileDeletedReceivers=[];

function ReadServerConfigXML() {
    global $xml;
    $xml=simplexml_load_file("ServerConfig.xml") or die("Error: Cannot create object");
    //print_r($xml);
}

function MailArrayLoad(){
    
    global $xml;
    global $UserProfileCreatedMessage;
    global $UserProfileCreatedReceivers;

    //for "user created" mail
    $UserProfileCreatedMessage=(array)$xml->Notifications->Mail->Message[0];
    $UserProfileCreatedReceivers=(array)$xml->Notifications->Mail->Message[0]->Receivers; 
    //echo "<br>array_message=";print_r($UserProfileCreatedMessage);
    /*as a reference:
    $UserProfileCreatedMessage['Subject'];//subject
    $UserProfileCreatedMessage['Body'][0];//body info
    $UserProfileCreatedMessage['Body'][1];//userid
    $UserProfileCreatedMessage['Body'][2];//name
    $UserProfileCreatedMessage['Body'][3];//username
    $UserProfileCreatedMessage['Body'][4];//password
    $UserProfileCreatedMessage['Body'][5];//warning
    $UserProfileCreatedMessage['Body'][6];//farewell
    $UserProfileCreatedMessage['Body'][7];//modifierid
    $UserProfileCreatedMessage['Footer'];//footer
    $UserProfileCreatedMessage['Logo'];//logo path
    $UserProfileCreatedReceivers['Technician'];//tech
    $UserProfileCreatedReceivers['Developer'];//developer
    $UserProfileCreatedReceivers['Owner'];//owner
    $UserProfileCreatedReceivers['User'];//user      
    */
    
    //profile changed message mail
    $UserProfileDataChangedMessage=(array)$xml->Notifications->Mail->Message[1];
    $UserProfileDataChangedReceivers=(array)$xml->Notifications->Mail->Message[1]->Receivers; 
    
    //profile access data changed mail
    $UserAccessDataChangedMessage=(array)$xml->Notifications->Mail->Message[2];
    $UserAccessDataChangedReceivers=(array)$xml->Notifications->Mail->Message[2]->Receivers;
    
    //profile flagged for delete mail
    $UserProfileFlaggedForDeletionMessage=(array)$xml->Notifications->Mail->Message[3];
    $UserProfileFlaggedForDeletionReceivers=(array)$xml->Notifications->Mail->Message[3]->Receivers;
    
    //profile deleted message mail
    $UserProfileDeletedMessage=(array)$xml->Notifications->Mail->Message[4];
    $UserProfileDeletedReceivers=(array)$xml->Notifications->Mail->Message[4]->Receivers;
    
    $PatientProfileCreatedMessage=(array)$xml->Notifications->Mail->Message[5];
    $PatientProfileCreatedReceivers=(array)$xml->Notifications->Mail->Message[5]->Receivers;    
    
    $PatientProfileDataChangedMessage=(array)$xml->Notifications->Mail->Message[6];
    $PatientProfileDataChangedReceivers=(array)$xml->Notifications->Mail->Message[6]->Receivers;

    $PatientProfileFlaggedForDeletionMessage=(array)$xml->Notifications->Mail->Message[7];
    $PatientProfileFlaggedForDeletionReceivers=(array)$xml->Notifications->Mail->Message[7]->Receivers;

    $PatientProfileDeletedMessage=(array)$xml->Notifications->Mail->Message[8];
    $PatientProfileDeletedReceivers=(array)$xml->Notifications->Mail->Message[8]->Receivers;    

    $CompanyProfileCreatedMessage=(array)$xml->Notifications->Mail->Message[9];
    $CompanyProfileCreatedReceivers=(array)$xml->Notifications->Mail->Message[9]->Receivers;

    $CompanyProfileDataChangedMessage=(array)$xml->Notifications->Mail->Message[10];
    $CompanyProfileDataChangedReceivers=(array)$xml->Notifications->Mail->Message[10]->Receivers;
    
    $CompanyProfileFlaggedForDeletionMessage=(array)$xml->Notifications->Mail->Message[11];
    $CompanyProfileFlaggedForDeletionReceivers=(array)$xml->Notifications->Mail->Message[11]->Receivers;
    
    $CompanyProfileDeletedMessage=(array)$xml->Notifications->Mail->Message[12];
    $CompanyProfileDeletedReceivers=(array)$xml->Notifications->Mail->Message[12]->Receivers;
    
    
}
//eof

//---loading arrays



    $UserProfileCreated=array(
        
        "Subject"=>0,
        
        
    );


//-end of loading arrays



function ReadBooks(){
    
    echo "<br>Books";
    $xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
    echo $xml->book[0]['category'] . "<br>";
    echo $xml->book[1]->title['lang']; 
    
}

print "\nv1.0";
ReadServerConfigXML();
MailArrayLoad();
//echo "<br>";print_r($array);

//ReadBooks();
/*
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title; 
*/

?>
