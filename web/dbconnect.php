<?php
if (!($mysqli = new mysqli("127.0.0.1", "dbuser", "dbpassword"))) {
    die("Database Connection Error ! --> " . $mysqli->error);
}
if (!$mysqli->select_db("security")) {
    print("Database Selection Error ! --> " . $mysqli->error);
}
//global settings
$my_date = date("d/m/Y H:i");
//socket connection
class socketClient
{
    function socketMesage($message)
    {
        $address = "127.0.0.1";
        $port    = "72";
        //$message = "reqestData";
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

?>
