<?php
use registration\User_IP_Address;
use registration\DatabaseManipulation;

//Instantiate the the user ip class
$ip = new User_IP_Address();
//Instantiate the database class
$db = new DatabaseManipulation($filename);
/*Get the submitted registration data*/
//Get Username
$registration['username'] = isset($_POST['usrname'])?filter_input(INPUT_POST, 'usrname', FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
//Get Password
$registration['password'] = isset($_POST['password'])?filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
//Get confirmed pass
$registration['con_pass'] = isset($_POST['con_pass'])?filter_input(INPUT_POST, 'con_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
//Get Email
$registration['email'] = isset($_POST['email'])?filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL):"";
//Get user ip
$registration['ip'] = $ip->userIP();






/*Destroy Objects*/
$ip = null;
$db = null;




