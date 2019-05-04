<?php


namespace registration;


class Authentication
{
    /**
     * This method checks password and confirm password is a match
     *
     * @param string $pass
     * @param string $con_pass
     * @return bool
     */
    public function passMatch(string $pass, string $con_pass):bool{
        if($pass === $con_pass){
            return true;
        }
        return false;
    }

    /**
     * Checks if some of the input fields are empty;
     * This method uses bitwise operation;
     * If there is only on element in the array, $true is equal to 1
     * If there are two elements in the array ,$true is equal to 3
     * if There are 4 fields in the array, $true is equal to 15
     *
     * @param array $input
     * @param int $true
     * @return bool
     */
    public function checkInput(array $input, int $true):bool{
        $iteration = 0;
        $base = 0;
        $shift = 1;
        foreach ($input as $value){
            if($value !== ""){
                $base ^= ($shift << $iteration);
            }
            $iteration++;
        }
        if($true === $base){
            return true;
        }
        return false;
    }
}