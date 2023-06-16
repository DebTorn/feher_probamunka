<?php

    namespace controllers;

    require_once("models/User.php");
    use models\User;

    class LoginController{

        private function show(){
            $content = 'views/login.php';
            include 'views/main.php';
        }

        public function index(){
            $this->show();
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                if(empty($_POST['email']) || empty($_POST['jelszo'])){
                    array_push($GLOBALS['errors'], "Valamelyik kötelező mező hiányos!");
                }

                $GLOBALS['datas']['email'] =  $_POST['email'];

                if(empty($GLOBALS['errors'])){
                    $email = $_POST['email'];
                    $jelszo = md5($_POST['jelszo']);
        
                    $user = new User();
        
                    $user->findByEmail($email);
        
                    if($user && $user->passwordCheck($jelszo)){
                        $_SESSION['email'] = $user->getEmail();
                        $_SESSION['id'] = $user->getId();
                        $_SESSION['nev'] = $user->getNev();
                        header("Location: /probamunka/");
                        die();
                    }else{
                        array_push($GLOBALS['errors'], "Bejelentkezés sikertelen!");
                        header("Location: /probamunka/login/login?errors=".urlencode(json_encode($GLOBALS['errors']))."&datas=".urlencode(json_encode($GLOBALS['datas'])));
                        die;
                    }
                }else{
                    header("Location: /probamunka/login/login?errors=".urlencode(json_encode($GLOBALS['errors']))."&datas=".urlencode(json_encode($GLOBALS['datas'])));
                    die;
                }

            }else{
                $this->show();
            }

        }

        public function logout(){
            session_unset();
            session_destroy();

            header("Location: /probamunka/login/login");
            die();
        }
    }

?>