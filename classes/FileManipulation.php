<?php


namespace registration;


class FileManipulation
{
    /*
     * path+name of the file
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Gets contents from the given file and checks if the database table exists or not
     *
     * @return boolean
     */
    function checkForTable():bool {
        $contents = file_get_contents($this->filename);
        $array = json_decode($contents, true);
        if(isset($array['dbtable'])){
            return true;
        }
        return false;
    }

    /**
     * Check if the information needed for database connection is properly entered
     *
     * @param array $config_key Json key
     * @param int $true_value   integer value equals to the $base_bit when all the information is properly entered
     * @return bool
     */
    function checkForDatabase(array $config_key, int $true_value):bool {
        $base_bit = 0;
        $bit_operand = 1;
        $iteration = 0;
        $contents = file_get_contents($this->filename);
        $array = json_decode($contents, true);
        foreach($config_key as $value){
            if(isset($array[$value])){
                $base_bit ^= $bit_operand << $iteration;
                $iteration++;
            }
        }
        return ($base_bit === $true_value)?true:false;
    }

    /**
     * Create config.json
     *
     * @param array $config_argument_array A php array containing database information
     * @return bool
     */
    public function createConfigFile(array $config_argument_array):bool{
        $data_json = json_encode($config_argument_array);
        $handle = fopen($this->filename, "w");
        $db_info_entered=fwrite($handle,$data_json);
        if($db_info_entered){
            fclose($handle);
            return true;
        }
        return false;
    }

    /**
     * Indicates whether the database table was exists  or not
     *
     * @return bool
     */
    public function dbTableIndicator():bool{
        $content = file_get_contents($this->filename);
        $array = json_decode($content, true);
        $array['table'] = "dr_reg";
        $indicator = $this->createConfigFile($array);
        return $indicator;
    }
}