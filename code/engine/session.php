<?php


//FUNCTION DEF
function SessionStart($userid){
    
    session_start();
    $_SESSION["UserID"] = $userid;
    $_SESSION["Date"] = "12-21-2005";
    
    //print "<br>\nSession user=". $_SESSION["UserID"];
    //print "<br>\nSession date=". $_SESSION["Date"];    

}

function PrintSessionInfo(){
    
    //print "<br>\nSession user=". $_SESSION['UserID'];
    //print "<br>\nSession date=". $_SESSION['Date'];
    
}


function SessionDestroy(){
    
    session_destroy();
}


//END OF FUNCTION DEF














?>