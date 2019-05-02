<?php

//Store the project root directory path and url
$root_dir = __DIR__;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//Include the classes;
require_once $root_dir."/classes/FileManipulation.php";
require_once $root_dir."/classes/DatabaseManipulation.php";

//Check the config.json file
require_once $root_dir."./includes/file-manipulation.php";
require_once $root_dir."./includes/db_manipulation.php";
//Display the registration form
//header("location:./views/index.html");