<?php

    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", ""); // Update with your credentials
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT username, message, created_at FROM messages ORDER BY created_at ASC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);


?>
