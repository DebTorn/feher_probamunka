<?php

    namespace models;

    require_once('models/DB.php');
    use App\DB;

    require_once('models/User.php');
    use models\User;

    use Exception;

    class Chat{

        private $userId;
        private $message;
        private $sent;
        private $tableName = 'chat';

        //GETTER
        public function getUser(){
            $user = new User();

            return $user->findById($this->userId);
        }
        public function getMessage(){
            return $this->message;
        }
        public function getSent(){
            return $this->sent;
        }
        public function getTableName(){
            return $this->tableName;
        }

        public function getAllVariables(){
            $vars = get_object_vars($this);
            unset($vars["tableName"]);
            return $vars;
        }

        //SETTER
        public function setUserId($userId){
            $this->userId = $userId;
        }
        public function setMessage($message){
            $this->message = $message;
        }
        public function setSent($sent){
            $this->sent = $sent;
        }

        //METHODS
        public function save(string $where = null){

            try{
                $db = new DB();
                $chat = $this;
                return $db->saveDB($chat, $where);
            }catch(Exception $e){
                throw new Exception("Chat save error: ". $e->getMessage());
            }
        }

        public function getAllMessages(){

            try{
                $db = new DB();
                $result = $db->find($this, null, null, ['field' => 'sent', 'type' => 'DESC']);

                if(count($result) > 0){
                    return $result;
                }

                return null;

            }catch(Exception $e){
                throw new Exception("Chat find error: ". $e->getMessage());
            }

        }

    }
    

?>