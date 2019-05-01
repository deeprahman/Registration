<?php
use registration\FileManipulation;
//Instantiate the FileManipulation class
$filename = "config.json";
$fn = new FileManipulation($filename);

if(isset($_POST['db_info'])) {
    $db_array['hostname'] = isset($_POST['hostname']) ? filter_input(INPUT_POST, 'hostname', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $db_array['database'] = isset($_POST['database']) ? filter_input(INPUT_POST, 'database', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $db_array['port'] = isset($_POST['port']) ? filter_input(INPUT_POST, 'port', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $db_array['username'] = isset($_POST['db_username']) ? filter_input(INPUT_POST, 'db_username', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $db_array['password'] = isset($_POST['db_password']) ? filter_input(INPUT_POST, 'db_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

}
if(!file_exists($filename)){
    header("location:./views/dbinfo.html");
}

$update = $fn->dbTableIndicator();
if($update){
    echo "updated";
}else{
    echo "not updated";
}