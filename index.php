<?php

//Store the project root directory path and url
$root_dir = __DIR__;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$filename = "config.json";
$table_name = "dr_reg";
//Include the classes;
require_once $root_dir."/classes/FileManipulation.php";
require_once $root_dir."/classes/DatabaseManipulation.php";
require_once $root_dir."/classes/User_IP_Address.php";
require_once $root_dir."/classes/Authentication.php";
require_once $root_dir."/classes/DateTimeCheck.php";



//When the submit button of the Database information form is clicked- get the information cand create the config.json
if(isset($_POST['db_info'])){
    require_once $root_dir . "/includes/get-db-info.php";
}
//Create an instance of the Database Manipulation class, if config.json exists
if(file_exists($filename)){
    require_once $root_dir."/includes/db-connect.php";
    //IF the register button is clicked, handle the submitted data
    if(isset($_POST['register'])){
        require_once $root_dir.'/includes/register.php';
    }
    //Include The registration form
    include $root_dir."/views/registration.html.php";
}



//Display Database Information Entry Page if config.json is not exists
if(!file_exists("config.json")){
    include $root_dir."/views/dbinfo.html.php";
    exit();
}

