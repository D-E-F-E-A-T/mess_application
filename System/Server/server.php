<?php
require '../../vendor/autoload.php';
require '../../Application/Services/Chat.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


/**
 * Create a new connection to
 * the database that we can inject
 * to our chat class later on in
 * the code.
 */
 
/**
 * Instantiate the chat server
 * on the configured port in
 * includes/config.php.
 *
 * The includes/classes/Chat.php class will
 * handle all the events and database interactions.
 */
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat(null) /* This class will handle the chats. It is located in includes/classes/Chat.php */
        )
    ),
    8080
);

echo "Server running at 8080 \n";

/**
 * Run the server
 */
$server->run();
