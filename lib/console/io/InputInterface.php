<?php

namespace Console\Io;

interface InputInterface
{
    function getCommand(): ?string;

    /**
     * @return InputArg[]
     */
    function getInputArgs(): array;

    function getInputArg(string $name): ?InputArg;
}