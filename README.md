# UDPSocket-simple
This program can easily handle UDP Socket in PHP

# Usage
1.
```php
include __DIR__ . '/UDPSocket.php';

$socket = new UDPSocket();
```
2.
```php
$s1 = $socket->createSocket('test1', '127.0.0.1', 1); // craete 1 port
$s2 = $socket->createSocket('test2', '127.0.0.1', 2); // create 2 port
```
3.
```php
if (!$s1 or !$s2){ // enable check
    return;
}
```
4.
```php
$key = 'djfklasdhnfhjdskf'; // encrypt key
$message = $socket->encryptText('test messasge', $key); // encrypt
```
5.
```php
while(true){

    $socket->sendData('127.0.0.1', 1, 2, $message); // send Message

    $socket->receiveData($address, $sendPort, 2, $text); // receive Message

    var_dump($socket->decryptText($text, $key)); // dump Message
    
    sleep(1);

}
```
