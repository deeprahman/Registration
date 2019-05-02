<?php

use registration\DatabaseManipulation;

$filename = "config.json";
$dbm = new DatabaseManipulation($filename);

if($dbm->createTable()){
    echo "Table Exists";
}else{
    echo "table does not exists";
}