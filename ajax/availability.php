<?php

require_once '../classes/DatabaseManipulation.php';
require_once '../classes/FileManipulation.php';
use registration\DatabaseManipulation;
use registration\FileManipulation;

$filename = "../config.json";
$fm = new FileManipulation($filename);
$table = $fm->checkForTable();
if(!$table){
    echo 1;
    exit;
}



$username_ind = 1;
$email_ind = 1;


$email = isset($_POST['email'])?$_POST['email']:'';
//When username is not empty, check availability

if((isset($_POST['username']) && $_POST['username'] !== '')){
    $db = new DatabaseManipulation($filename);
    $results = $db->fetchWhereColHead('username',$_POST['username']);
    if($results){
        $username_ind = 0;
        echo $username_ind;
    }else{
        echo $username_ind;
    }
    exit;
}

if((isset($_POST['email']) && $_POST['email'] !== '')){
    $db = new DatabaseManipulation($filename);
    $results = $db->fetchWhereColHead('email',$_POST['email']);
    if($results){
        $email_ind = 0;
        echo $email_ind;
    }else{
        echo $email_ind;
    }
}