<?php

    namespace controllers;

    class HomeController{

        private function show(){
            $content = 'views/home.php';
            include 'views/main.php';
        }

        public function index(){
            $this->show();
        }

    }

?>