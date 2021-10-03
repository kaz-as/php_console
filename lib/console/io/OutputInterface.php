<?php

namespace Console\Io;

interface OutputInterface
{
    function out(string $s = '', bool $newline = true): void;
}
