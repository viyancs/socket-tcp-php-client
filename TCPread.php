<?php
define('__LIB__', dirname(dirname(__FILE__)));
require_once(__LIB__ . '/TCP/library/TCPConnection.php');
require_once(__LIB__ . '/TCP/library/TCPCallback.php');

$socket = new TCPConnection();
if (!socket_last_error($socket->getSocket())) {
    if ($buffer = socket_read($socket->getSocket(), 512, PHP_NORMAL_READ)) {
        $json = json_decode($buffer, true);
        if ($json === null) {
            //$this->getCallback()->onMessage($buffer);
            echo 'ai';
        } else if ($json !== null) {

            /*if (array_key_exists("name", $json) === true && array_key_exists("args", $json) === true) {
                $this->getCallback()->onJSONEvent($json['name'], $json['args']);
            } else {
                $this->getCallback()->onJSON($json);
            }*/
            echo 'haloo';
        }
    }
}
?>
