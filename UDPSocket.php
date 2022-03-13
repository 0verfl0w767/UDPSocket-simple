<?php

# version: 1.0.0 (2022.3.14)

$socket_list = [];

function createSocket(string $name, string $address, int $port): bool{

    global $socket_list;

    if (isset($socket_list[$port])){
        return false;
    }

    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    if ($socket === false){
        return false;
    }

    $bind = socket_bind($socket, $address, $port);

    if ($bind === false){
        return false;
    }

    $nonblock = socket_set_nonblock($socket);

    if ($nonblock === false){
        return false;
    }

    $socket_list[$port] = [];
    $socket_list[$port]['name'] = $name;
    $socket_list[$port]['socket'] = $socket;

    return true;

}

function closeSocket(int $port): bool{

    global $socket_list;

    if (!isset($socket_list[$port])){
        return false;
    }

    socket_close($socket_list[$port]);

    unset($socket_list[$port]);

    return true;
    
}

function sendData(string $address, int $sendPort, int $recvPort, string $text): bool{

    global $socket_list;

    if (!isset($socket_list[$sendPort])){
        return false;
    }

    $send = socket_sendto($socket_list[$sendPort]['socket'], $text, strlen($text), 0, $address, $recvPort);

    if (!$send){
        return false;
    }

    return true;

}

function receiveData(?string &$address, ?int &$sendPort, int $recvPort, ?string &$text): bool{

    global $socket_list;

    if (!isset($socket_list[$recvPort])){
        return false;
    }

    $recv = socket_recvfrom($socket_list[$recvPort]['socket'], $text, 1024, 0, $address, $sendPort);

    if (!$recv){
        return false;
    }

    return true;

}


$_1 = createSocket('test1', '127.0.0.1', 1);
$_2 = createSocket('test2', '127.0.0.1', 2);

if (!$_1 or !$_2){
    return;
}

while(true){

    sendData('127.0.0.1', 1, 2, 'test message');

    receiveData($address, $sendPort, 2, $text);

    var_dump($text);
    
    sleep(1);

}

?>