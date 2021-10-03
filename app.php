<?php

use Console\Application;
use Console\Command;

if (php_sapi_name() !== 'cli') {
    exit;
}

spl_autoload_register(function ($className) {
    $psrDir = 'lib';
    $className = str_replace("\\", '/', $className);
    $class = "$psrDir/$className.php";
    include_once($class);
});

$console = new Application();

/** @var Command[] $commands */
$commands = [];

foreach ($commands as $command) {
    $console->add($command);
}

$console->run();
