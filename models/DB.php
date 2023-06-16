<?php

    namespace App;

    use PDO;
    use PDOException;
    use Exception;

    class DB{

        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "probamunka";
        private $conn;

        public function __construct(){
            try {
                $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Connection failed: " . $e->getMessage());
            }
        }

        public function __destruct()
        {
            $this->conn = null;
        }

        public function saveDB($object, string $where = null){
            try{

                $fields = array();
                $values = array();

                foreach($object->getAllVariables() as $key => $value){
                    array_push($fields, $key);
                    array_push($values, $value);
                }

                $params = array();
                for($i = 0; $i < count($fields); $i++){
                    $params[$i] = ":".$fields[$i];
                }

                if(is_null($where)){
                    $sql = "INSERT INTO ". $object->getTableName() ." (". implode(',', $fields) .") VALUES (". implode(',', $params) .")";
                }else{
                    $set = array();
                    for($i = 0; $i < count($fields); $i++){
                        array_push($set, $fields[$i]."= ".$params[$i]);
                    }
                    $sql = "UPDATE ". $object->getTableName() ." SET ". implode(',', $set)." WHERE $where";
                }

                $stmt = $this->conn->prepare($sql);
                for($i = 0; $i < count($params); $i++){
                    $stmt->bindParam($params[$i], $values[$i]);
                }

                return $stmt->execute();
                
            }catch(PDOException $e){
                throw new Exception("Mentési hiba: ". $e->getMessage());
            }
        }

        public function find($object = null, array $where = null, array $select = null, array $order = null){
            try{
                
                if(is_null($where)){
                    if(is_null($select)){
                        $sql = "SELECT * FROM ". $object->getTableName();
                    }else{
                        $sql = "SELECT ".implode(',', $select)." FROM ". $object->getTableName();
                    }
                }else{
                    $whKeys = array();
                    foreach($where as $key => $value){
                        array_push($whKeys, $key." = :".$key);
                    }

                    if(is_null($select)){
                        $sql = "SELECT * FROM ". $object->getTableName() ." WHERE ". implode(',', $whKeys);
                    }else{
                        $sql = "SELECT ".implode(',', $select)." FROM ". $object->getTableName() ." WHERE ". implode(',', $whKeys);
                    }
                }
                
                if(!is_null($order)){
                    $sql .= ' ORDER BY '. $order['field'] . ' ' . $order['type'];
                }

                $stmt = $this->conn->prepare($sql);

                if(!is_null($where)){
                    foreach($where as $key => $value){
                        $stmt->bindParam(":".$key, $value);
                    }
                }

                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                return null;


            }catch(PDOException $e){
                throw new Exception("Lekérdezési hiba: ". $e->getMessage());
            }
        }

    }

?>