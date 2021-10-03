<?php

namespace Console\Io;

interface InputInterface
{
    function getCommand(): string;

    /**
     * @return Argument[]
     */
    function getArguments(): array;

    function getArgument(string $name): ?Argument;

    /**
     * @return Parameter[]
     */
    function getParameters(): array;

    function getParameter(string $name): ?Parameter;
}