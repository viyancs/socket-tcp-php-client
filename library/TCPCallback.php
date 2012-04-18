<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
* TCP Implementation - socket-tcp-php-client
*
* interface TCPCallback
*
*
* @author M Sofiyan
* @email msofyancs@gmail.com
* @skypeid viyancs
* if you want to using part of full this code, please don't remove this comment
*
**/
interface TCPCallback {
    //put your code here
    public function onJSONEvent($event,$jsonArray);
    public function onJSON($json);
    public function onMessage($message);
    public function onConnect();
    public function onDisconnect();
    public function onError($err);
    public function onSend($msg);
}

?>
