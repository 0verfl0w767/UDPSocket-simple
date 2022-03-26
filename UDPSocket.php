<?php

/**
 * 
 *         888                                                    .d8888b.   .d8888b.  
 *        888                                                  d88P  Y88b d88P  Y88b 
 *       888                                                       .d88P 888        
 *   .d88888  .d88b.  888  888        888  888 .d8888b           8888"  888d888b.  
 *  d88" 888 d8P  Y8b 888  888       888  888 88K                "Y8b. 888P "Y88b 
 *  888  888 88888888 Y88  88P      888  888 "Y8888b.      888    888 888    888 
 *  Y88b 888 Y8b.      Y8bd8P       Y88b 888      X88      Y88b  d88P Y88b  d88P 
 *  "Y88888  "Y8888    Y88P         "Y88888  88888P'       "Y8888P"   "Y8888P"  
 *                                     888                                       
 *                               Y8b d88P                                       
 *                                "Y88P"                                        
 */


# version: 1.0.0 (2022.3.14)
# version: 1.0.1 (2022.3.26)

class UDPSocket{

    private array $socketList = [];

    public function __construct(){
        //todo
    }

    public function createSocket(string $name, string $address, int $port): bool{

        if (isset($this->socketList[$port])){
            
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

        $this->socketList[$port] = [];
        $this->socketList[$port]['name'] = $name;
        $this->socketList[$port]['socket'] = $socket;

        return true;

    }

    public function closeSocket(int $port): bool{

        if (!isset($this->socketList[$port])){

            return false;

        }

        socket_close($this->socketList[$port]);

        unset($this->socketList[$port]);

        return true;
        
    }

    public function sendData(string $address, int $sendPort, int $recvPort, string $text): bool{

        if (!isset($this->socketList[$sendPort])){

            return false;

        }

        $send = socket_sendto($this->socketList[$sendPort]['socket'], $text, strlen($text), 0, $address, $recvPort);

        if (!$send){

            return false;

        }

        return true;

    }

    public function receiveData(?string &$address, ?int &$sendPort, int $recvPort, ?string &$text): bool{

        if (!isset($this->socketList[$recvPort])){
            return false;
        }

        $recv = socket_recvfrom($this->socketList[$recvPort]['socket'], $text, 1024, 0, $address, $sendPort);

        if (!$recv){

            return false;

        }

        return true;

    }

    public function encryptText(string $text, string $key): string|false{

        return openssl_encrypt($text, 'aes-256-cbc', $key, 0, str_repeat(chr(0), 16));

    }

    public function decryptText(string $text, string $key): string|false{

        return openssl_decrypt($text, 'aes-256-cbc', $key, 0, str_repeat(chr(0), 16));

    }

    public function getSocketList(): array{

        return $this->socketList;

    }

}

?>