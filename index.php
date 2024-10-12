<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <style>
        #chat {
            height: 400px;
            border: 1px solid #000;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            overflow-y: auto; /* Enable scrolling */
        }
        .message-input, .username-input {
            width: 20%;
            margin-bottom: 10px;
        }
        .message {
            margin-bottom: 10px;
        }
        .message p {
            background-color: #e9ecef;
            border-radius: 15px;
            padding: 10px;
        }
        .message p.sent {
            background-color: #0d6efd;
            color: #fff;
            text-align: right;
        }
        .message p.received {
            background-color: #e9ecef;
            color: #000;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="usernameDiv">
        <input type="text" id="usernameInput" placeholder="Enter your username" autofocus>
        <button id="setUsername">Set Username</button>
    </div>

    <div id="chatDiv" style="display:none;">
        <div id="chat"></div>

        <input type="text" id="message" placeholder="Enter your message">
        <button id="send">Send</button>
    </div>

    <script>
        var conn;
        var chatBox = document.getElementById('chat');
        var messageInput = document.getElementById('message');
        var sendButton = document.getElementById('send');
        var username;

        document.getElementById('setUsername').onclick = function() {
            username = document.getElementById('usernameInput').value;
            if (username) {
                document.getElementById('usernameDiv').style.display = 'none';
                document.getElementById('chatDiv').style.display = 'block';
                loadOldMessages();  // Load previous messages
                connectToChat();    // Initialize WebSocket connection
            } else {
                alert('Please enter a username');
            }
        };

        // Load old messages from the server
        function loadOldMessages() {
            fetch('get_messages.php')  // Assuming your PHP file is named get_messages.php
                .then(response => response.json())
                .then(messages => {
                    if (messages.error) {
                        console.error("Error fetching messages:", messages.error);
                        return;
                    }

                    messages.forEach(msg => {
                        chatBox.innerHTML += `<p><strong>${msg.username}</strong>: ${msg.message} <em>${msg.created_at}</em></p>`;
                    });
                    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to bottom
                })
                .catch(error => {
                    console.error("Error loading messages:", error);
                });
        }

        function connectToChat() {
            conn = new WebSocket('ws://localhost:8080'); // Correct WebSocket URL

            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                let data = JSON.parse(e.data);
                chatBox.innerHTML += `<p><strong>${data.username}:</strong> ${data.message}</p>`;
                chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to bottom
            };

            sendButton.onclick = function() {
                if (messageInput.value) {
                    let msgObj = { username: username, message: messageInput.value };
                    conn.send(JSON.stringify(msgObj));  // Send username and message
                    messageInput.value = ''; // Clear input field
                }
            };

            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendButton.click();
                }
            });
        }
    </script>



<script>
    async function fetchMessages() {
        
            const response = await fetch('get_messages.php');
            const messages = await response.json();

            const messagesList = document.getElementById('messages');
            messagesList.innerHTML = ''; // Clear existing messages

            if (messages.error) {
                console.error(messages.error);
                return;
            }

            messages.forEach(msg => {
                const li = document.createElement('li');
                li.textContent = `${msg.username}: ${msg.message} (at ${msg.created_at})`;
                messagesList.appendChild(li);
            });
        // } catch (error) {
        //     console.error('Error fetching messages:', error);
        // }
    }

    // Fetch messages when the page loads
    window.onload = fetchMessages;
</script>

</body>
</html>
