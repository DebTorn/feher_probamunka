<?php

    namespace controllers;

    require_once('models/User.php');
    use models\User;
    use DateTime;

    class UserController{

        private function show($user){
            $content = 'views/profile.php';
            include 'views/main.php';
        }

        private function profileUpdateShow($user){
            $content = 'views/profileUpdate.php';
            include 'views/main.php';
        }

        public function profile(){

            $user = new User();
            $user->findByEmail($_SESSION['email']);

            $this->show($user);
            
        }

        public function update(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $user = new User();

                $user->findById($_SESSION['id']);

                if(empty($_POST['email']) || empty($_POST['nev']) || empty($_POST['csaladi_allapot'])){
                    array_push($GLOBALS['errors'], "Valamelyik kötelező mező hiányos");
                }else{
                    if($_POST['email'] != $user->getEmail()){
                        $user2 = new User();
                        if($user2->findByEmail($_POST['email']) && !is_null($user2->getId())){
                            array_push($GLOBALS['errors'], "Ilyen e-mail címmel már van regisztrált felhasználó!");
                        }
                    }

                    if(!in_array($_POST['csaladi_allapot'], $GLOBALS['allapotok'])){
                        array_push($GLOBALS['errors'], "A családi állapot csak a következő lehet: egyedülálló, házas vagy elvált!");
                    }

                    if(!empty($_POST['szuletesi_ido'])){
                        
                        $date = DateTime::createFromFormat('Y-m-d', $_POST['szuletesi_ido']);
                        $formatted = $date->format('Y-m-d');
    
                        if($date && $formatted === $_POST['szuletesi_ido']){
                            if(strtotime($formatted) <= strtotime(date("Y-m-d"))){
                                $user->setSzuletesiIdo($_POST['szuletesi_ido']);
                            }else{
                                array_push($GLOBALS['errors'], "A dátumnak kisebbnek kell lennie a mai dátumnál");
                            }
                        }else{
                            array_push($GLOBALS['errors'], "A dátum formátuma hibás");
                        }
                         
                    }else{
                        $user->setSzuletesiIdo(null);
                    }

                }

                if(empty($GLOBALS['errors'])){

                    if(!empty($_POST['weboldal'])){
                        $user->setWeboldal($_POST['weboldal']);
                    }else{
                        $user->setWeboldal(null);
                    }

                    $user->setEmail($_POST['email']);
                    $user->setNev($_POST['nev']);
                    $user->setCsaladiAllapot($_POST['csaladi_allapot']);

                    $_SESSION['email'] = $_POST['email'];

                    if($user->save('id = :id')){
                        header("Location: /probamunka/user/profile");
                        die;
                    }else{
                        array_push($GLOBALS['errors'], 'Sikertelen módosítás!');
                        header("Location: /probamunka/user/update?errors=".urlencode(json_encode($GLOBALS['errors'])));
                        die;
                    }
                }else{
                    header("Location: /probamunka/user/update?errors=".urlencode(json_encode($GLOBALS['errors'])));
                    die;
                }

            }else{

                $user = new User();
                $user->findByEmail($_SESSION['email']);

                $this->profileUpdateShow($user);
            }
        }

        public function changepw(){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $user = new User();
                $user->findById($_SESSION['id']);

                if($user->passwordCheck(md5($_POST['regi_jelszo']))){ //Ha a beírt pass megegyezik a régi jelszóval
                    if(strlen($_POST['uj_jelszo']) < 4 || !(preg_match('/[a-zA-Z]/', $_POST['uj_jelszo']) && preg_match('/\d/', $_POST['uj_jelszo']))){
                        array_push($GLOBALS['errors'], "A jelszó minimum 4 karakter legyen, valamint tartalmazzon legalább egy betűt és egy számot!");
                    }else{
                        $newPass = password_hash(md5($_POST['uj_jelszo']), PASSWORD_BCRYPT);

                        $user->setJelszo($newPass);
    
                        if($user->save('id = :id')){
                            header("Location: /probamunka/login/logout");
                            die;
                        }else{
                            array_push($GLOBALS['errors'], 'Sikertelen módosítás!');
                            header("Location: /probamunka/user/profile?errors=".urlencode(json_encode($GLOBALS['errors'])));
                            die;
                        }
                    }

                }else{
                    array_push($GLOBALS['errors'], "A régi jelszó helytelen!");
                }

                header("Location: /probamunka/user/profile?errors=".urlencode(json_encode($GLOBALS['errors'])));
                die;

            }else{
                header("Location: /probamunka/user/profile");
                die;
            }
        }

    }

?>