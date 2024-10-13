<?php
session_start();
require '../vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

$id = $_GET['id'] ?? null; // Make sure 'id' is set

if ($id) {
    // Ensure the ID is an integer to prevent SQL injection
    $id = (int)$id;

    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // echo "<h1>Message from Chat</h1>";
        // echo "<p>" . htmlspecialchars($row['message']) . "</p>";
    } else {
        echo "No message found.";
    }
} else {
    echo "Invalid message ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Form Submission</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa; /* Light background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            transition: box-shadow 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.3);
        }

        input {
            display: block;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        #response {
            margin-top: 15px;
            font-size: 14px;
            color: #e74c3c; /* Error message color */
        }

        .chat-container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            margin-top: 20px;
        }

        #chat-box {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            margin-bottom:30px;
        }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['user_id'])) { ?>

        <div class="container mt-5">
            <div class="form-container">
                <h2 class="text-center mb-4">Login Form</h2>
                <form id="login-user">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send</button>
                </form>
                <div id="response" class="mt-3"></div>
            </div>
        </div>


    <?php } else { ?>

        <div class="container mt-5">
            <div class="chat-container">
                <h2 class="text-center mb-4">Chat With <?php echo  $_SESSION['username']; ?></h2>
                <div id="chat-box" style="color: red; height: 400px; overflow-y: auto;">
                    <!-- Chat messages will be displayed here -->
                </div>
                <form id="message-form" class="d-flex">
                    <input type="text" id="message" class="form-control me-2" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
                <a href="../logout.php"> Logout</a>
            </div>
        </div>


    <?php } ?>

    <script>
        $(document).ready(function() {

            $('#message-form').on('submit', function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var resever_id = <?php echo $id ?>; // 
                var sender_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

                if (sender_id !== null && resever_id !== null) {
                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST', 
                        data: {
                            message: message,
                            resever_id: resever_id,
                            sender_id: sender_id
                        },
                        success: function(response) {
                            $('#chat-box').append('<div>' + response + '</div>'); 
                            $('#message').val(''); // Clear the input field
                        },
                        error: function(xhr, status, error) {
                            $('#chat-box').append('<div>Error sending message: ' + error + '</div>');
                        }
                    });
                } else {
                    alert('You must be logged in to send a message.');
                }
            });

            $('#login-user').submit(function(e) {
                e.preventDefault();
                var formData = {
                    username: $('#name').val(),
                    email: $('#email').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../register.php',
                    data: formData,
                    success: function(response) {
                        $('#response').html('<p>' + response + '</p>');
                        $('#login-user')[0].reset();
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('<p>Error occurred. Please try again later.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>
