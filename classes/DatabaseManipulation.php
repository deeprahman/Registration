<?php


namespace registration;


class DatabaseManipulation
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $dbname;
    /**
     * @var string
     */
    private $dsn;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $table_name;

    /**
     * @var object
     */
    private $pdo;

    /**
     * DatabaseManipulation constructor.
     * @param string $filename
     */
    public function __construct(string &$filename)
    {
        $this->filename = $filename;
        $this->databaseInfo($filename);
        $this->pdo = $this->dbConnect();
    }

    /**
     * Assigns value to the properties
     *
     * @param string $filename
     */
    private function databaseInfo(string $filename):void {
        $json_data = file_get_contents($filename);
        $db_info_array = json_decode($json_data, true);
        $host=& $db_info_array['hostname'];
        $dbname =& $db_info_array['database'];
        $port =& $db_info_array['port'];
        $username =& $db_info_array['username'];
        $password =& $db_info_array['password'];
        $table_name =& $db_info_array['table'];
        $this->table_name = $table_name;
        $this->dbname = $dbname;
        $this->dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Connect to the database
     *
     * @return \PDO
     */
    private function dbConnect():\PDO {
        $options = [
            \PDO::ATTR_ERRMODE                   =>      \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE        =>      \PDO::FETCH_ASSOC
        ];
        try{
           $pdo = new \PDO($this->dsn,$this->username,$this->password,$options);
        }catch (\PDOException $ex){
            exit($ex->getMessage());
        }
        return $pdo;
    }

    /**
     * Check for database table named "reg_info"
     */
     public function checkTable():bool{
         $db =& $this->pdo;
         $select = <<<EOL
SELECT * 
FROM information_schema.tables
WHERE table_schema = :dbname
    AND table_name = :table_nm
LIMIT 1;       
EOL;
        $prepared = $db->prepare($select);
        $prepared->execute([
            'dbname'        =>  $this->dbname,
            'table_nm'      => $this->table_name
        ]);
        $results = $prepared->fetch();
        $table_exists = ($results)?true:false;
        return $table_exists;
     }

     /**
      * Create table
      */
     public function createTable():bool{
         $table = "dr_reg";
         $sql = <<<EOL
CREATE TABLE {$table}(
  reg_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  user_pass VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;
EOL;
        $db =& $this->pdo;
        try{
            $db->exec($sql);
            $this->table_name = $table;
        }catch(\PDOException $ex){
            exit($ex->getMessage());
        }
        $table_exists = $this->checkTable();
        return $table_exists;
     }
}