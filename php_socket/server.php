<?php
/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/7/22
 * Time: 21:01
 */
$sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
socket_bind($sock, '127.0.0.1','8080');
socket_listen($sock,9);
while (1){
    $client = socket_accept($sock);
    if($client){
        while (1){
            $bytes = @socket_recv($socket, $buffer, 2048, 0);
            if($bytes > 9){
                socket_write($socket, $bytes, strlen($bytes));
                echo $bytes;
            }
        }
        var_dump($client,(int)$client);

    }
}