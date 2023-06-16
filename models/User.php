<?php

    namespace models;

    require_once('models/DB.php');
    use App\DB;
    use DateTime;
    use Exception;

    class User{
        private $id;
        private $email;
        private $jelszo;
        private $nev;
        private $csaladi_allapot;
        private $szuletesi_ido;
        private $weboldal;
        private $tableName = 'user';

        public function __construct(){}

        //GETTER
        public function getId(){
            return $this->id;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getNev(){
            return $this->nev;
        }
        public function getCsaladiAllapot(){
            return $this->csaladi_allapot;
        }
        public function getSzuletesiIdo(){
            return $this->szuletesi_ido;
        }
        public function getWeboldal(){
            return $this->weboldal;
        }
        public function getKor(){
            $today = new DateTime();
            $born = new DateTime($this->szuletesi_ido);
            $diff = $today->diff($born)->y;

            return $diff;
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
        public function setId($id){
            $this->id = $id;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setNev($nev){
            $this->nev = $nev;
        }
        public function setCsaladiAllapot($allapot){
            $this->csaladi_allapot = $allapot;
        }
        public function setSzuletesiIdo($szulido){
            $this->szuletesi_ido = $szulido;
        }
        public function setWeboldal($weboldal){
            $this->weboldal = $weboldal;
        }
        public function setJelszo($jelszo){
            $this->jelszo = $jelszo;
        }

        //METHODS
        public function save(string $where = null){
            try{
                
                $db = new DB();
                $user = $this;
                return $db->saveDB($user, $where);

            }catch(Exception $e){
                throw new Exception("Save error: ". $e->getMessage());
            }
        }

        public function findById($id){
            try{
                $db = new DB();

                $result = $db->find($this, ['id' => $id]);

                if(count($result) > 0){
                    $res = $result[0];

                    $this->setId($res['id']);
                    $this->setEmail($res['email']);
                    $this->setJelszo($res['jelszo']);
                    $this->setNev($res['nev']);
                    $this->setCsaladiAllapot($res['csaladi_allapot']);
                    $this->setSzuletesiIdo($res['szuletesi_ido']);
                    $this->setWeboldal($res['weboldal']);

                }

            }catch(Exception $e){
                throw new Exception("Find error: ". $e->getMessage());
            }
        }

        public function findByEmail($email){
            try{
                $db = new DB();

                $result = $db->find($this, ['email' => $email]);

                if(count($result) > 0){
                    $res = $result[0];

                    $this->setId($res['id']);
                    $this->setEmail($res['email']);
                    $this->setJelszo($res['jelszo']);
                    $this->setNev($res['nev']);
                    $this->setCsaladiAllapot($res['csaladi_allapot']);
                    $this->setSzuletesiIdo($res['szuletesi_ido']);
                    $this->setWeboldal($res['weboldal']);
                    return true;
                }

                return false;

            }catch(Exception $e){
                throw new Exception("Find error: ". $e->getMessage());
            }
        }

        public function passwordCheck($_password){
            return password_verify($_password, $this->jelszo);
        }

    }

?>