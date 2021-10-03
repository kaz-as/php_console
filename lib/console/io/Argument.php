<?php

namespace Console\Io;

class Argument
{
    function __construct(private string $name) {}

    function getName(): string
    {
        return $this->name;
    }
}