<?php
require 'vendor/autoload.php';
require './Chat.php';
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat(null)  
        )
    ),
   8080
);

echo "Server running at 8080c\n";
 
$server->run();
