<?php

/**
* TCP Implementation - socket-tcp-php-client
*
* create new TCPClient
* connection socket to server
* sending message to server
* implement callback for receive message from server  
*
* @author M Sofiyan
* @email msofyancs@gmail.com
* @skypeid viyancs
* if you want to using part of full this code, please don't remove this comment
*
**/

define('__LIB__', dirname(dirname(__FILE__)));
require_once(__LIB__ . '/php/library/TCPConnection.php');
require_once(__LIB__ . '/php/library/TCPCallback.php');

class TCPClient implements TCPCallback {
        public $socket;
    public function index() {
        $this->socket = new TCPConnection("127.0.0.1", 1338, $this);
        $data = array("username" => "foo", "pass" => "bar");
        $this->socket->connect();
        //$socket->send("testing socket TCP dari viyancs"); // format string only
        //$socket->emit("login",  array((object)($data),  (object)($data1))); //multy dimension json
        $this->socket->emit("login", array($data)); //one array dimension json
    }

    public function onConnect() {
        echo "socket is connected </br>";
        echo "-------------------------------------------------------------</br>";
    }

    public function onDisconnect() {
        echo "socket is disconnected </br>";
        echo "-------------------------------------------------------------</br>";
    }

    public function onError($err) {
        echo "something wrong : " .$err;
    }

    public function onJSON($json) {
        echo "receive data from server </br>";
        echo "=============================================================</br>";
        echo "the data is " .$json. '</br>';
        echo "=============================================================</br>";
    }

    public function onJSONEvent($event, $jsonArray) {
        echo "receive data from server </br>";
        echo "=============================================================</br>";
        echo "the event is " .$event. '</br>';
        foreach ($jsonArray as $key => $value) {
            echo "Key: $key; </br>";
            var_dump($value); echo '</br>';
        }
        echo "=============================================================</br>";
    }

    public function onMessage($message) {
        echo "message from sever :" .$message;
    }

    public function onSend($msg) {
        echo "sending data to server </br>";
        echo "=============================================================</br>";
        echo 'data = ' .$msg .'</br>';
        echo "=============================================================</br>";
    }

}

$client = new TCPClient();
$client->index();

?>

