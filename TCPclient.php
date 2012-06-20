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
 * */
define('__LIB__', dirname(dirname(__FILE__)));
require_once(__LIB__ . '/TCP/library/TCPConnection.php');
require_once(__LIB__ . '/TCP/library/TCPCallback.php');

class TCPClient implements TCPCallback {

    public $socket;

    public function index() {
        $this->socket = new TCPConnection("127.0.0.1", 1338, $this);
        $this->socket->connect(); //connection to socket
        $data = array("username" => "foo", "pass" => "bar");
        //TCPConnection::send("testing socket TCP dari viyancs"); // format string only
        //TCPConnection::emit("login",  array((object)($data),  (object)($data1))); //multy dimension json
        //$this->socket->emit("login", array($data)); //one array dimension json
        TCPConnection::emit("login", array($data));

    }

    public function onConnect() {
        echo "socket is connected \n";
        echo "-------------------------------------------------------------\n";
    }

    public function onDisconnect() {
        echo "socket is disconnected \n";
        echo "-------------------------------------------------------------\n";
    }

    public function onError($err) {
        echo "something wrong : " . $err .'\n';
    }

    public function onJSON($json) {
        echo "receive data from server \n";
        echo "=============================================================\n";
        echo "the data is " . $json . '\n';
        echo "=============================================================\n";
    }

    public function onJSONEvent($event, $jsonArray) {
        echo "receive data from server </br>";
        echo "=============================================================\n";
        echo "the event is " . $event . '\n';
        foreach ($jsonArray as $key => $value) {
            echo "Key: $key; \n";
            var_dump($value);
            echo '\n';
        }
        echo "=============================================================\n";
    }

    public function onMessage($message) {
        echo "message from sever :" . $message .'\n';
    }

    public function onSend($msg) {
        echo "sending data to server \n";
        echo "=============================================================\n";
        echo 'data = ' . $msg . '\n';
        echo "=============================================================\n";
    }

}

$client = new TCPClient();
$client->index();
?>

