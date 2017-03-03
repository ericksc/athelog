<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//global vars
$xml="";//xml file

//global for mail
/*
$UserProfileCreated=[];
$UserProfileDataChanged
UserAccessDataChanged
UserProfileFlaggedForDeletion
UserProfileDeleted
PatientProfileCreated
PatientProfileDataChanged
PatientProfileFlaggedForDeletion
PatientProfileDeleted
CompanyProfileCreated
CompanyProfileDataChanged
CompanyProfileFlaggedForDeletion
CompanyProfileDeleted        
*/
//print "\nRead XML";



function CheckServerConfigXML() {
    global $xml;
    $xml=simplexml_load_file("ServerConfig.xml") or die("Error: Cannot create object");
}

function ReadServerConfigXML_Mail(){
    
   
    $xml = simplexml_load_file("ServerConfig.xml");
    $xml2 = simplexml_load_file("books.xml") or die("Error: Cannot create object");
    $items = array();
    //print_r($response);
    
    /*
    foreach ($response->Notifications->Mail->xpath('//Message') as $item)
    {
        $Type = (string) $item['Type'];
        foreach ($item->xpath('Section') as $attr)
        {
            $Info = (string) $attr['Info'];
            $items[$Type][$Info] = (string) $attr;
        }
    }*/

    echo "<br>Content of XML";   
    //echo "<br>".$xml->Message[0]['Type'];
    echo"<br>Message Type";
    echo "<br>".$xml->Notifications->Mail->Message[0]['Type'];
    echo "<br>".$xml->Notifications->Mail->Message[1]['Type'];
    echo "<br>".$xml->Notifications->Mail->Message[2]['Type'];
    echo "<br>".$xml->Notifications->Mail->Message[3]['Type'];
    
    //echo "<br>".$xml2->book[0]['category'];
    //echo "<br>".$xml->Message[0]->Subject;
    
    
    //print_r($items);
    
}
//eof

function ReadBooks(){
    
    echo "<br>Books";
    $xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
    echo $xml->book[0]['category'] . "<br>";
    echo $xml->book[1]->title['lang']; 
    
}

print "\nv1.0";
//CheckServerConfigXML();
ReadServerConfigXML_Mail();
//ReadBooks();
/*
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title; 
*/

?>
