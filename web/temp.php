<?php
class socketClient
{
    function socketMesage()
    {
        $address = "127.0.0.1";
        $port    = "72";
        $message = "reqestData";
        ($socket = socket_create(AF_INET, SOCK_STREAM, 0)) or
            die("Cannot connect to the server");
        socket_connect($socket, $address, $port) or
            die("Cannot Connect to the data server");
        socket_write($socket, $message);
        $read = socket_read($socket, 1024);
        socket_close($socket);
        $read = trim($read, " () ");
        $read = explode(",", $read);
        return $read;
    }
}

$a = socketClient::socketMesage();
//echo trim($a[0], "[ ' ]");
for ($i = 0; $i < count($a); $i++) {
    echo trim($a[$i], "[ ' ]");
}

//echo substr($a[2], 0, 10);
//echo implode(',', $a[0] );
//print_r($a);
// Test if string contains the word 
//if(strpos($read, 'temp') !== false){
//    echo "Word Found!";
//} else{
//    echo "Word Not Found!";
//}
?>