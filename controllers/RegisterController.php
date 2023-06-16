<?php

    namespace controllers;

    require_once('models/User.php');
    use models\User;
    use DateTime;

    class RegisterController{

        private function show(){
            $content = 'views/register.php';
            include 'views/main.php';
        }

        public function index(){
            $this->show();
        }

        public function register(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $user = new User();

                $allapotok = [
                    'egyedulallo',
                    'hazas',
                    'elvalt'
                ];
    
                if(empty($_POST['email']) || empty($_POST['jelszo']) || empty($_POST['nev']) || empty($_POST['csaladi_allapot'])){
                    array_push($GLOBALS['errors'], "Valamelyik kötelező mező hiányos");
                }else{
                    if($user->findByEmail($_POST['email']) && !is_null($user->getId())){
                        array_push($GLOBALS['errors'], "Ilyen e-mail címmel már van regisztrált felhasználó!");
                    }else if(strlen($_POST['jelszo']) < 4 || !(preg_match('/[a-zA-Z]/', $_POST['jelszo']) && preg_match('/\d/', $_POST['jelszo']))){
                        array_push($GLOBALS['errors'], "A jelszó minimum 4 karakter legyen, valamint tartalmazzon legalább egy betűt és egy számot!");
                    }else if(!in_array($_POST['csaladi_allapot'], $allapotok)){
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
                         
                    }

                }


                $GLOBALS['datas']['email'] =  $_POST['email'];
                $GLOBALS['datas']['nev'] =  $_POST['nev'];
                $GLOBALS['datas']['csaladi_allapot'] =  $_POST['csaladi_allapot'];
                $GLOBALS['datas']['szuletesi_ido'] =  $_POST['szuletesi_ido'];
                $GLOBALS['datas']['weboldal'] =  $_POST['weboldal'];

                if(empty($GLOBALS['errors'])){

                    if(!empty($_POST['weboldal'])){
                        $user->setWeboldal($_POST['weboldal']);
                    }

                    $user->setEmail($_POST['email']);
                    $user->setJelszo(password_hash(md5($_POST['jelszo']), PASSWORD_BCRYPT));
                    $user->setNev($_POST['nev']);
                    $user->setCsaladiAllapot($_POST['csaladi_allapot']);

                    if($user->save()){
                        header("Location: /probamunka/login/login");
                        die;
                    }else{
                        array_push($GLOBALS['errors'], 'Sikertelen feltöltés!');
                        header("Location: /probamunka/register/register?errors=".urlencode(json_encode($GLOBALS['errors']))."&datas=".urlencode(json_encode($GLOBALS['datas'])));
                        die;
                    }
                }else{
                    header("Location: /probamunka/register/register?errors=".urlencode(json_encode($GLOBALS['errors']))."&datas=".urlencode(json_encode($GLOBALS['datas'])));
                    die;
                }

            }else{
                $this->show();
            }

        }

    }

?>