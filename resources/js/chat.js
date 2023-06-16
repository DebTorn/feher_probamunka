// chat.js

function ChatApp(name) {
    var socket;

    this.init = function() {
        
        socket = new WebSocket('ws://localhost:8090/probamunka/server-socket.php');

        socket.onmessage = function(event){
            var message = JSON.parse(event.data);

            if(message.message != null){
                var messageText = "";
                if(message.type == 'connection'){
                    messageText = message.message;
                }else{
                    messageText = message.name + ' ('+ message.sent +'): ' + message.message;
                }
    
                var messageElement = document.createElement('div');
                messageElement.textContent = messageText;
        
                var chatMessages = document.getElementById('chatMessages');
                chatMessages.insertBefore(messageElement, chatMessages.firstChild);
            }
        }

        socket.onerror = function(event){
            var messageElement = document.createElement('div');
            messageElement.textContent = "Hiba történt";
    
            var chatMessages = document.getElementById('chatMessages');
            chatMessages.insertBefore(messageElement, chatMessages.firstChild);
        }

        socket.onclose = function(event){
            var messageElement = document.createElement('div');
            messageElement.textContent = "A kapcsolat megszakadt";
    
            var chatMessages = document.getElementById('chatMessages');
            chatMessages.insertBefore(messageElement, chatMessages.firstChild);
        }

        socket.onopen = function(event){
            var messageElement = document.createElement('div');
            messageElement.textContent = "A kapcsolat létrejött";
    
            var chatMessages = document.getElementById('chatMessages');
            chatMessages.insertBefore(messageElement, chatMessages.firstChild);
        }
        
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
        
            var message = document.getElementById('messageInput').value;

            if (message) {
                var messageData = {
                    name: name,
                    message: message,
                    sent: ''
                };

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/probamunka/chat/send', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {   //Ha sikeres volt a feltöltés
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if(response.success){
                            messageData.sent = response.sent;
                            document.getElementById('messageInput').value = '';
                            socket.send(JSON.stringify(messageData));
                        }
                        
                    }
                };

                xhr.send('message=' + encodeURIComponent(message));
            }
        });
    };

}
