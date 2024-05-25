<?php

// 确保Swoole扩展已安装
// 在命令行运行以下命令安装：
// pecl install swoole
 
use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
 
// 创建WebSocket服务器对象
$server = new Server('0.0.0.0', 9501);

 
// 监听WebSocket连接打开事件
$server->on('open', function (Server $server, Request $request) {
    echo "新连接，客户端ID：{$request->fd}\n";
});
 
// 监听WebSocket消息事件
$server->on('message', function (Server $server, Frame $frame) {
    echo "接收消息：{$frame->data}\n";
 
    // 广播消息给所有连接的客户端
    foreach ($server->connections as $clientId) {
        $server->push($clientId, $frame->data);
    }
});
 
// 监听WebSocket连接关闭事件
$server->on('close', function ($ser, $fd) {
    echo "连接关闭，客户端ID：$fd\n";
});
 
// 启动WebSocket服务器
$server->start();

