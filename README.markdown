socket-tcp-php-client
============

this repository is communication using protocol tcp with the server using nodejs(net required) and the client using php, before you use this repository i'm recommended to read
this article [TCP introduction](https://github.com/viyancs/socket-udp-java-client/wiki), because any some different in TCP and UDP.
<br>

requiretment 
-----------------------
<br>
1) nodejs <br>
2) php5-sockets



Running The Application
-----------------------

* install nodejs <br>
* install php5-sockets <br>
* install IDE(recomended Netbeans because the repository using netbeans) <br>
	 
* run the server that been use nodejs<br>

* for the server code  <br>
<pre>

    var net = require('net');
    var server = net.createServer(function (socket) {
    // We have a connection - a socket object is assigned to the connection automatically
    console.log('CONNECTED: ' + socket.remoteAddress +':'+ socket.remotePort);
    var nama = false;
    socket.on('data', function(data) {    
        //var datas = JSON.parse(data); //if you receive json must be parse 
        console.log('DATA ' + socket.remoteAddress + ': ' + data);  
        socket.write("you said: " + data + '\r\n');
        socket.end();
    });
    socket.on('connect', function() {
        console.log("client already connected");
    });
    socket.on('end', function() {
        console.log('DONE');
    });
    });

    server.listen(1338, '127.0.0.1');
    console.log("server is listen on 1338");

</pre>


save to app.js run with `sudo node app.js` <br> or in windows you can use `node.exe app.js` 

* run in the browser TCPClient.php<br>
<pre>
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
</pre>

Features
-----------------------

* send data using string format 
* send data using JSONFormat (JSONObject,JSONArray) and dynamical JSON.
* receive data using string format
* receive data using json format


Bugging 
-----------------------

* problem when receive data from server after connected to server

Licence 
----------------------
if you want to use this repository please  don't remove comment in each code, fork and follow this repository if any question send email to msofyancs@gmail.com , i wanna to update this code to be better.

	

