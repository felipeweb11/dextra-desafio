<?php

require __DIR__.'/../vendor/autoload.php';

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {
    try {
        return App\Http\App::instance()->dispatch($request);
    } catch (Exception | Error | Throwable $e) {
        return new React\Http\Response(500, [], $e->getMessage());
    }
});

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server('0.0.0.0:3000', $loop);
$server->listen($socket);
echo 'Server running at port 3000' . PHP_EOL;
$loop->run();