<?php
/**
 * StatusPoster class: perform stuatus insertion to database
 * and fetching status posts from database
 */
class StatusPoster {
    private $db = NULL;
    
    const DB_SERVER = "localhost"; 
    const DB_USER = "root"; 
    const DB_PASSWORD = "root"; 
    const DB_NAME = "status_poster"; 
    
    public function __construct() {
        $dsn = 'mysql:dbname='.self::DB_NAME.';host='.self::DB_SERVER;

        try {
            $this->db = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
        
        return $this->db;
    }

    public function insertStatus(array $values){

        $sql = "INSERT INTO status ";
        $fields = array_keys($values);
        $vals = array_values($values);
        
        $sql .= '('.implode(',', $fields).') ';
        
        $arr = array();
        foreach ($fields as $f) {
            $arr[] = '?';
        }
        $sql .= 'VALUES ('.implode(',', $arr).') ';
        
        $statement = $this->db->prepare($sql);
        
        foreach ($vals as $i=>$v) {
            $statement->bindValue($i+1, $v);
        }
        
        return $statement->execute(); 
    }

    public function getStatusPosts() {

        $statement = $this->db->prepare("SELECT name, image, status, timestamp FROM status ORDER BY timestamp DESC,id");
        $statement->execute();
                
        if ($statement->rowCount() > 0) {
            return $statement->fetchAll();
        }
        
        return false;
    }
}

$status = new StatusPoster();
?>
