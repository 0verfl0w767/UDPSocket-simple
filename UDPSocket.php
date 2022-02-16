<?php

$socket_list = [];

function createSocket($port): bool {

    if (isset($socket_list[$port])){
        return false;
    }

    $socket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    $bind = socket_bind($socket, "0.0.0.0", $port);

    if ($bind === false){
        return false;
    }

    @socket_set_nonblock($socket);

    $socket_list[$port] = $socket;

    return true;

}

function closeSocket($port): bool {

    if (!isset($socket_list[$port])){
        return false;
    }

    socket_close($socket_list[$port]);

    return true;
    
}

function send(){

}

function receive(){

}

createSocket('test', 1);

?>