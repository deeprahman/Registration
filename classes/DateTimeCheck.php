<?php


namespace registration;


class DateTimeCheck
{
    private $current_time;

    public function __construct()
    {
        try{

            $this->current_time = new \DateTime();
        }catch(\Exception $ex){
            exit($ex->getMessage());
        }
    }

    /**
     * Check the difference between current date time and given date time; if difference is greater than 3 days return false
     *
     * @param string $date_time
     * @return bool
     */
    public function difference(string $date_time):bool {
        //create a datetime instance for given time
        try {

            $given_date_time = new \DateTime($date_time);
            $diff = $this->current_time->diff($given_date_time);
            return ($diff->d > 3)?true:false;
        }catch(\Exception $ex) {
            exit($ex->getMessage());
        }
}

}