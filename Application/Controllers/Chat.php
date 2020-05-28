<?php
namespace MyApp;
use Ratchet\ConnectionInterface;
class Controller {
	
	/* @var \SplObjectStorage */
	public $clients;
	
	public function chat(ConnectionInterface $conn, $msgJson) {
		$this->sendToAll(['action'=>'chat', 'message'=>$msgJson->message, 'error'=>false]);
	}
	
	/**
	 * Sends a JSON-encoded message to the client
	 *
	 * @param ConnectionInterface $conn
	 * @param array|object $msgArray
	 */
	private function send(ConnectionInterface $conn, $msgArray){
		$conn->send(json_encode($msgArray));
	}

	/**
	 * Sends a JSON-encoded message to all the clients online
	 *
	 * @param ConnectionInterface $conn
	 * @param array|object $msgArray
	 */
	private function sendToAll($msgArray){
		$msgJson = json_encode($msgArray);
		foreach ($this->clients as $conn){
			$conn->send($msgJson);
		}
	}
	
}