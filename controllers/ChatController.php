<?php

    namespace controllers;

    require_once('models/Chat.php');
    use models\Chat;

    class ChatController{

        private $socket;
        private $client;
        
        private function show($messages){
            $content = 'views/chat.php';
            include 'views/main.php';
        }

        public function index(){
            $messages = new Chat();
            $msgs = $messages->getAllMessages();

            $this->show($msgs);
        }

        public function getMessages() {
            $chatMessage = new Chat();
            $messages = $chatMessage->getAllMessages();
    
            echo json_encode($messages);
        }
    
        public function send() {
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $chat = new Chat();
                $sent = date('Y-m-d H:i:s');

                $chat->setUserId($_SESSION['id']);
                $chat->setMessage($_POST['message']);
                $chat->setSent($sent);

                if($chat->save()){
                    echo json_encode(['success' => true, 'sent' => $sent]);
                }else{
                    echo json_encode(['success' => false]);
                }

            }else{
                header("Location: /probamunka/");
                die();
            }
        }

    }

?>