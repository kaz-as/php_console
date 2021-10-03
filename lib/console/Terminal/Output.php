<?php

namespace Console\Terminal;

/** Вывод с консоли */
class Output implements \Console\Io\OutputInterface
{

    function out(string $s = '', bool $newline = true): void
    {
        echo $s;
        if ($newline) {
            echo PHP_EOL;
        }
    }
}