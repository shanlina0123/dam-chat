<?php

use Swoole\WebSocket\Client;

$ws = new Client('0.0.0.0', 9501);
 
$ws->on('Open', function ($ws) {
    echo "connection to server established\n";
});
 
$ws->on('Message', function ($ws, $data) {
    echo "received message: {$data}\n";
});
 
$ws->on('Close', function ($ws) {
    echo "connection closed\n";
});
 
$ws->on('Error', function ($ws, $code, $msg) {
    echo "error: {$msg}\n";
});
 
$ws->connect();
 
// 发送消息
if ($ws->isConnected()) {
    $ws->push("Hello, Server!");
}
 
// 循环等待WebSocket服务器发送消息
while ($ws->isConnected()) {
    $ws->tick(1000);
}