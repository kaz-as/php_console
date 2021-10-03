<?php

namespace Console\Terminal;

use Console\Io\Argument;
use Console\Io\Parameter;

class Input implements \Console\Io\InputInterface
{

    function getCommand(): string
    {
        // TODO: Implement getCommand() method.
    }

    /**
     * @inheritDoc
     */
    function getArguments(): array
    {
        // TODO: Implement getArguments() method.
    }

    function getArgument(string $name): Argument
    {
        // TODO: Implement getArgument() method.
    }

    /**
     * @inheritDoc
     */
    function getParameters(): array
    {
        // TODO: Implement getParameters() method.
    }

    function getParameter(string $name): Parameter
    {
        // TODO: Implement getParameter() method.
    }
}