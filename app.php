<?php

namespace App;

use Console\Application;
use Console\Command;

require_once 'lib/console/include.php';

if (php_sapi_name() !== 'cli') {
    exit;
}

$console = new Application();

/** @var Command[] $commands */
$commands = [];

foreach ($commands as $command) {
    $console->add($command);
}

$console->run();
