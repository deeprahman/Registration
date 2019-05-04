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
        $host=& $db_info_array['host'];
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
     *
     * @return bool
     */
     public function createTable(string $table_name):bool{
         $table = $table_name;
         $sql = <<<EOL
CREATE TABLE {$table}(
  reg_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  user_pass VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  ip VARCHAR(30) NOT NULL,
  reg_date TIMESTAMP
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

    /**
     * Submit Data to the database
     *
     * @param array $data   key-value pair
     * @return bool
     */
     public function submitData(array &$data):bool{
         $db = $this->pdo;
         $col_name = [];
         $values=[];
         $prep = [];
         foreach($data as $heading => $value){
             array_push($col_name,$heading);
             array_push($values,$value);
             $prep[] = "?";
         }
        $col_name = implode(",",$col_name);
        $prep = implode(",",$prep);

         $insert = <<<EOL
INSERT INTO {$this->table_name}({$col_name}) VALUES ({$prep});
EOL;
        try{
           $prepared = $db->prepare($insert);
           $prepared->execute($values);

        }catch(\PDOException $ex){
            exit($ex->getMessage());
        }
        return true;

     }

    /**
     * Fetch Data From the Table
     *
     * @param array $col_head
     * @param string $where_clause
     * @return false|mixed|\PDOStatement
     */
     public function fetchData(array $col_head, string $where_clause = "") {
         $heading = implode(",",$col_head);
         $table =& $this->table_name;
         $db = $this->pdo;
         if(empty($where_clause)){
             $select = <<<EOL
SELECT {$heading} FROM {$table};
EOL;
         }else{
             $select = <<<EOL
SELECT {$heading} FROM {$table} WHERE {$where_clause};
EOL;
         }
        try{
           $results = $db->query($select);
           $results = $results->fetch();
        }catch(\PDOException $ex){
             exit($ex->getMessage());
        }
         return $results;
     }

    /**
     * Fetch data given where condition
     *
     * @param string $col_head
     * @param string $value
     * @return false|mixed|\PDOStatement
     */
     public function fetchWhereColHead(string $col_head,string $value){
         $where = <<<EOL
{$col_head}='{$value}'
EOL;
       //Convert string to array
         $array_col_head[]=$col_head;
         $results = $this->fetchData($array_col_head,$where);
         return $results;
     }

    /**
     * Fetch the registration time for a given IP
     *
     * @param string $col_head
     * @param string $where_head
     * @param string $where_value
     * @return false|mixed|\PDOStatement
     */
    public function fetchTimeForIp(string $col_head,string $where_head, string $where_value){
        $where = <<<EOL
{$where_head}='{$where_value}'
EOL;
        //Convert string to array
        $array_col_head[]=$col_head;
        $results = $this->fetchData($array_col_head,$where);
        return $results;
    }

}