<?php

use Console\Application;
use Console\Command;
use Console\Io\IoException;

if (php_sapi_name() !== 'cli') {
    exit;
}

spl_autoload_register(function ($className) {
    $psrDir = 'lib';
    $className = str_replace("\\", '/', $className);
    $class = "$psrDir/$className.php";
    include_once($class);
});

try {
    $console = new Application();

    /** @var Command[] $commands */
    $commands = [
        new \Commands\ShowInputArgs(),
    ];

    foreach ($commands as $command) {
        $console->add($command);
    }

    $console->run();
} catch (IoException $e) {
    echo "Input error: {$e->getMessage()}\n";
}
