<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
* TCP Implementation - socket-tcp-php-client
*
* writting socket
*
* @author M Sofiyan
* @email msofyancs@gmail.com
* @skypeid viyancs
* if you want to using part of full this code, please don't remove this comment
*
**/
class TCPMessage{
    private $socket;
    private $message;
    private $callback;
    
    public function __construct($sock,$callback) {
        $this->socket = $sock;
        $this->callback = $callback;
    }
    private function write() {
        $msg = $this->message;
        $length = strlen($msg);

        while (true) {
            $sent = socket_write($this->socket, $msg, $length);
            $this->callback->onSend($msg);
            if ($sent === false) {
                break;
            }
            // Check if the entire message has been sented
            if ($sent < $length) {
                // If not sent the entire message.
                // Get the part of the message that has not yet been sented as message
                $msg = substr($msg, $sent);
                // Get the length of the not sented part
                $length -= $sent;
            } else {
                break;
            }
        }
    }
    
    public function send($msg){
        $this->message = $msg;
        $this->write();
    }
}

?>
