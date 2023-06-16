<?php

    namespace controllers;

    class AnalysisController{

        private function show(){
            $content = 'views/analysis.php';
            include 'views/main.php';
        }

        public function index(){
            $this->show();
        }

        public function process(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $url = $_POST['urlIn'];

                $html = file_get_contents($url);
                $lowercaseHtml = strtolower($html);
                preg_match_all('/\b\w*a\w*\b/', $lowercaseHtml, $matches);
                $uniqueWords = array_unique($matches[0]);
                $wordsToShow = array_slice($uniqueWords, 0, 64);
                
                echo json_encode(array_chunk($wordsToShow, 8));

            }else{
                header("Location: /probamunka/");
                die();
            }
        }

    }

?>