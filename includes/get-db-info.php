<?php
use registration\FileManipulation;

$fm = new FileManipulation($filename);

$db_info['host'] = isset($_POST['hostname'])?filter_input(INPUT_POST,'hostname',FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
$db_info['database'] = isset($_POST['database'])?filter_input(INPUT_POST,'database',FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
$db_info['port'] = isset($_POST['port'])?filter_input(INPUT_POST,'port',FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
$db_info['username'] = isset($_POST['db_username'])?filter_input(INPUT_POST,'db_username',FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";
$db_info['password'] = isset($_POST['db_password'])?filter_input(INPUT_POST,'db_password',FILTER_SANITIZE_FULL_SPECIAL_CHARS):"";

//Create the config.json file
$created = $fm->createConfigFile($db_info);

$fm = null;