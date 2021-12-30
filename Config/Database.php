    <?php 

    require "config.php";

    class Database {
        private function db_connect() {
    
            try {
    
               return $conn = new \PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    
            } catch(\PDOException $e) {
                die("Connection failed. Error is: " . $e->getMessage());
            }
        }
    
        public function read($query, $data = []) {

            $DB = $this->db_connect();
            $statement = $DB->prepare($query);
            

            if (count($data) == 0) {
                $statement = $DB->query($query);
                $check = false;
                if ($statement) {
                    $check = true;
                }
            }
            $check = $statement->execute($data);

            if ($check) {

              return  $data = $statement->fetchAll(\PDO::FETCH_OBJ);
            } else {
                
                return false;
            }
    
        }
        public function write($query) {

            $DB = $this->db_connect();
            $statement = $DB->prepare($query);
            $check = $statement->execute();

            if ($check) {
                

              return  true;
            } else {
                
                return false;
            }
    
        }
    }