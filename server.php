<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $pdo;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        // Connect to the MySQL database
        $this->pdo = new \PDO("mysql:host=localhost;dbname=chat_db", "root", ""); // Update with your DB credentials
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        $username = $data['username'];
        $message = $data['message'];

        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" from "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $message, $username, $numRecv, $numRecv == 1 ? '' : 's');

        // Save message to the database
        $this->saveMessage($username, $message);

        // Broadcast message to all connected clients
        foreach ($this->clients as $client) {
            $client->send(json_encode(['username' => $username, 'message' => $message]));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function saveMessage($username, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
        $stmt->execute([
            ':username' => $username,
            ':message' => $message
        ]);
        echo "Message saved to the database.\n";
    }
}

// Set up the WebSocket server
$chatServer = new Chat();
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $chatServer
        )
    ),
    8080
);

echo "WebSocket server running on ws://localhost:8080...\n";
$server->run();


// old code 