<?php

use registration\User_IP_Address;
use registration\DatabaseManipulation;
use registration\Authentication;
use registration\FileManipulation;
use registration\DateTimeCheck;

//Instantiate the the user ip class
$ip = new User_IP_Address();
//Instantiate the database class
$db = new DatabaseManipulation($filename);
//Instantiate the Authentication class
$auth = new Authentication();
//Instance of FileManipulation
$fm = new FileManipulation($filename);
//Instantiate DateTimeCheck class
$dtc = new DateTimeCheck();
/*Get the submitted registration data*/
//Get Username
$registration['username'] = isset($_POST['usrname']) ? filter_input(INPUT_POST, 'usrname', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
//Get Password
$registration['user_pass'] = isset($_POST['password']) ? filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
//Get confirmed pass
$registration['con_pass'] = isset($_POST['con_pass']) ? filter_input(INPUT_POST, 'con_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
//Get Email
$registration['email'] = isset($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : "";
//Get user ip
$registration['ip'] = $ip->userIP();

//Check if some of the input fields are empty or not ; true vale is 31 as there are five fields to check and desimal value of binary 11111 is 31
$input_ok = $auth->checkInput($registration, 31);
//Check if the passwords are match
$pass_match = $auth->passMatch($registration['user_pass'], $registration['con_pass']);


if ($input_ok && $pass_match) {
    //If password and confirm password are match, create a hash
    $registration['user_pass'] = password_hash($registration['user_pass'], PASSWORD_DEFAULT);
    //Check if the database table exists
    $table_exists = $fm->checkForTable();
    //if table does not exists create the table and then continue
    if (!$table_exists) {

        $table_stat = $db->createTable($table_name);
        //If the table is successfully created, update the config.json
        if ($table_stat) {
            $json_update = $fm->jsonUpdate_table($table_name);
            //If the json not successfully updated, exit;
            if (!$json_update) {
                exit("Could not update config.json");
            }

        }
    }
    //Check if the Username and email are unique block
    {
        $chk_username = $db->fetchWhereColHead("username", $registration['username']);
        //Check if the email is unique
        $chk_email = $db->fetchWhereColHead("email", $registration['email']);
        if ($chk_email) {
            exit("Email Is not Unique");
        }
        if ($chk_username) {
            exit("Username Is not Unique");
        }
    }//End block

    //Check if the ip us unique block
    {

        $chk_ip = $db->fetchTimeForIp('reg_date','ip', $registration['ip']);
        //If the IP exists, check the duration between current and previous registration is 3 days
        $satisfy_days = true;
        if($chk_ip){
            $duration = $dtc->difference($chk_ip['reg_date']);
            //If duration is no less than 3 days, set false
            if(!$duration){
                $satisfy_days = false; //TODO use this information to block the registration
                exit("3 days barrier not satisfyied");
            }
        }
    }//end block
    //Submit data block
    {
        //Unset the confirm password element from the array
        unset($registration['con_pass']);
        $db->submitData($registration);
    }//end block
} else {
    header("location:$actual_link");
}


/*Destroy Objects*/
$ip = null;
$db = null;
$auth = null;
$dtc = null;




