<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
* TCP Implementation - socket-tcp-php-client
*
* create socket client
* connect to server
* send message string format
* send message json format
* read message from server after sending message
* disconnect socket 
*
*
* @author M Sofiyan
* @email msofyancs@gmail.com
* @skypeid viyancs
* if you want to using part of full this code, please don't remove this comment
*
**/
require_once(__LIB__.'/php/library/TCPMessage.php');

 class TCPConnection extends TCPMessage{
    private $ipAddress;
    private $port;
    private $socket;
    public $callback;
    
    public function __construct($address,$port,$callback) {
       $this->ipAddress = $address;
       $this->port = $port;
       $this->callback = $callback;
    }
    
    public function getCallback(){
        return $this->callback;
    }
    
    private function create() {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
            $this->getCallback()->onError(socket_strerror(socket_last_error()));
            exit();
        }
        socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0));
        $this->socket = $socket;
        return $socket;
    }
    
    public function connect() {
        $socket = $this->create();
        $result = socket_connect($socket, $this->ipAddress, $this->port);
        if ($result === false) {
            echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
            $this->getCallback()->onError(socket_strerror(socket_last_error($socket)));
            exit();
        }
        $this->getCallback()->onConnect();
        //$this->test();
    }
    
    public function send($message){
         $tcp = new TCPMessage($this->socket,$this->callback);
         $tcp->send($message);
    }
    
    public function emit($event,$msg=array()){
         if(is_array($msg)=== false){
             echo "emit() failed.\n Reason:($msg)" . " must be array format </br>";
             $this->getCallback()->onError("emit() failed.\n Reason:($msg)" . " must be array format </br>");
             exit();
         }
         $tcp = new TCPMessage($this->socket,$this->callback);
         $array = array("name"=>$event,
                         "args"=>$msg);
         $json = json_encode($array);
         $tcp->send($json);
         //$this->test();
    }
    
    /*private function read() {
        if (!socket_last_error($this->socket)) {
            if ($buffer = socket_read($this->socket, 512, PHP_NORMAL_READ)) {
                $json = json_decode($buffer, true);
                if($json === null){
                    $this->getCallback()->onMessage($buffer);
                }else if($json !== null){

                    if(array_key_exists("name", $json) === true && array_key_exists("args", $json) === true){
                        $this->getCallback()->onJSONEvent($json['name'],$json['args']);                       
                    }else{
                        $this->getCallback()->onJSON($json);
                    }
                }
                
            }
        }
    }
    
    public function test(){
        $reply = "";
        do {
            $recv = "";
            $recv = socket_read($this->socket, '1400');
            if ($recv != "") {
                $reply .= $recv;
            }
        } while ($recv != "");

        echo($reply);
    }*/

    public function disconnect(){        
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
        $this->getCallback()->onDisconnect();
    }
    
}

?>
