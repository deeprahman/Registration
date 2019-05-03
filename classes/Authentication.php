<?php


namespace registration;


class Authentication
{
    public function passMatch(string $pass, string $con_pass){
        if($pass === $con_pass){
            return true;
        }
        return false;
    }
}