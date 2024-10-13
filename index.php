<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Chat Application - Login/Register</title>
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

<?php
    // session_destroy(); 
    // var_dump( $_SESSION);
    if (!isset($_SESSION['user_id'])) {

    ?>
  
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

    <?php } else {
    
        // var_dump( $_SESSION);
        $role_id = $_SESSION['role_id'] ;
        if ($role_id==1) {
            header("Location: admin/index.php"); 
        }

        ?>
        <div class="container mt-5">
            <div class="chat-container">
                <h2 class="text-center mb-4">Chat Room</h2>
                <div id="chat-box" style="color: red; height: 400px; overflow-y: auto;">
                    <!-- Chat messages will be displayed here -->
                </div>
                <form id="message-form" class="d-flex">
                    <input type="text" id="message" class="form-control me-2" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
                <a href="logout.php"> Logout</a>
            </div>
        </div>
 


<?php } ?>

<script>
    // user login 
    $(document).ready(function() {

        $('#message-form').on('submit', function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var conversation_id = <?php echo isset($_SESSION['conversation_id']) ? $_SESSION['conversation_id'] : 'null'; ?>; // Set the correct conversation ID dynamically if needed
                var sender_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>; // Check if user_id is set

                if (sender_id !== null) {
                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST', 
                        data: {
                            message: message,
                            conversation_id: conversation_id,
                            sender_id: sender_id
                        },
                        success: function(response) {
                            $('#chat-box').append('<div>' + response + '</div>'); // Append the new message
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
                    url: 'register.php',
                    data: formData,
                    success: function(response) {
                        $('#response').html('<p>' + response + '</p>'); // Show the response message
                        $('#login-user')[0].reset(); // Reset the form
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('<p>Error occurred. Please try again later.</p>');
                    }
                });
            });


    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<!-- // css change -->