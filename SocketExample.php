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

include __DIR__ . '/UDPSocket.php';

$socket = new UDPSocket();

$s1 = $socket->createSocket('test1', '127.0.0.1', 1);
$s2 = $socket->createSocket('test2', '127.0.0.1', 2);

if (!$s1 or !$s2){
    return;
}

$key = 'djfklasdhnfhjdskf';
$message = $socket->encryptText('test messasge', $key);

while(true){

    $socket->sendData('127.0.0.1', 1, 2, $message);

    $socket->receiveData($address, $sendPort, 2, $text);

    var_dump($socket->decryptText($text, $key));
    
    sleep(1);

}

?>