<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function ConexionDB($query){
    // $connect = mysqli_connect("mysql.hostinger.es","u505969032_ramvq","joliewatt0123","u505969032_bicoy");
    $connect = mysqli_connect("mysql.hostinger.es","u884088163_erix","L4rd_erix","u884088163_irixs");
    $result = mysqli_query($connect,$query);
    return $result;
}

function ConexionDB_JSON($query){
    $result = ConexionDB($query);
    $data = array();
    if (is_bool($result) == FALSE){
	while ($row = mysqli_fetch_array($result)) {
	  $data[] = $row;
	}
        print json_encode($data);
        }
}

function ConexionDB_rawdata($query){
    $result = ConexionDB($query);
    $data = array();
	while ($row = mysqli_fetch_array($result)) {
	  $data[] = $row;
	}
    return $data;
}

function ConexionDBResult_NumRowAfected($query){
    $result = ConexionDB($query);
    $row_cnt = mysqli_num_rows($result);
    return $row_cnt;
}

function ConexionDBResult_PrintArray($query){
    $result = ConexionDB($query);
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
      $data[] = $row;
    }
    print_r($data);
}
?>

