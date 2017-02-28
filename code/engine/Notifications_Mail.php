<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//function to read notifications params
function ReadUserNotificationParams(){
 
 
 $MailDestination = "rvargas@athelog.net";//FIXME:read this CONST file
 $MailHeaders = "From:Bicoyed"."\r\n";//FIXME:read this CONST file
 $MailHeaders .= "CC:ramirovq@gmail.com";//FIXME:read this CONST file

 
 $Password="DummyPassword"; //FIXME:read this from dB
 $Username="DummyName";//FIXME:read this from dB
 $Type_Param=""; 
 $MailSubject = "";
 $MailText = "Estimado(a) ";
 
 if (isset($_GET['UserIDToken'])) {
  $UserID_Param=$_GET['UserIDToken'];
  
  if($UserID_Param!="NONE"){

   if (isset($_GET['TypeToken'])) {
    $Type_Param=$_GET['TypeToken']; 
   } 
  
  
   $MailText .= $UserID_Param .",";
   
   if($Type_Param=="UserAccountCreated"){
    $MailSubject = "Bicoyed: Bienvenido al programa de salud";
    $MailText .= "\nBicoyed le saluda y le da la bienvenida al programa de salud. Sus datos de acceso al programa son los siguientes:";
    $MailText .= "\nUsuario=".$Username;
    $MailText .= "\nClave=".$Password;
    $MailText .= "\n\nLe rogamos dar la debida protección a sus datos. Por favor no comparta su usuario ni clave, y haga click en el botón de Salida para finalizar cada sesión.";
    $MailText .= "\nGracias. Atentamente,\n-el equipo Bicoyed";
    $MailText .= "\n\nNota: Este correo es generado automáticamente, así que no es posible responder a él. En caso de tener preguntas, le invitamos a enviarlas a: dummy@soporte.com"; 
   
   }else if($Type_Param=="UserProfileDataChanged"){
    
    $MailSubject = "Bicoyed: Su perfil ha sido modificado";
    $MailText .= "\nSus datos de perfil de usuario han sido modificados. Para ver los cambios por favor ingrese al portal web y diríjase a la sección Mi Cuenta.";
    $MailText .= "\n\nGracias. Atentamente,\n-el equipo Bicoyed";
    $MailText .= "\n\nNota: Este correo es generado automáticamente, así que no es posible responder a él. En caso de tener preguntas, le invitamos a enviarlas a: dummy@soporte.com";
   
   }else if($Type_Param=="UserAccessDataChanged"){
    
    $MailSubject = "Bicoyed: Sus datos de acceso al programa";
    $MailText .= "\nSus datos de acceso al programa son los siguientes:";
    $MailText .= "\nUsuario=".$Username;
    $MailText .= "\nClave=".$Password;    
    $MailText .= "\n\nGracias. Atentamente,\n-el equipo Bicoyed";
    $MailText .= "\n\nNota: Este correo es generado automáticamente, así que no es posible responder a él. En caso de tener preguntas, le invitamos a enviarlas a: dummy@soporte.com";
 
   }else{
    echo "\nMail NOT sent - Type invalid";
    return -1; //Type is unknown
   }
   
  }else{
   echo "\nMail NOT sent - UserID si NONE";
   return -1.1; //UserID is NONE   
  } 
    
 }else{
   echo "\nMail NOT sent - UserID invalid";
   return -2; //UserID is unknown    
 }

 mail($MailDestination,$MailSubject,$MailText,$MailHeaders);
 echo "\nMail sent";
 return 0; //succesfully executed
 
}
//eof
?>