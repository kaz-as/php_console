<?php

namespace Console\Terminal;

use Console\Io\InputArg;
use Console\Io\InputException;
use Console\Parameter;

class Input implements \Console\Io\InputInterface
{
    private string $commandName;
    /**
     * Группировка — по имени.
     * @var InputArg[]
     */
    private array $args;

    function __construct(?string $argClass = null)
    {
        if (!$argClass) {
            /** @var InputArg $argClass */
            $argClass = Parameter::class;
        }
        $args = $_SERVER['argv'];
        if (count($args) < 2) {
            throw new InputException('Please specify the command name');
        }
        array_shift($args);
        $this->commandName = array_shift($args);
        foreach ($args as $arg) {
            $params = $argClass::parse($arg);
            foreach ($params as $param) {
                $this->args[$param->getName()] = $param;
            }
        }
    }

    function getCommand(): string
    {
        return $this->commandName;
    }

    /**
     * @inheritDoc
     */
    function getInputArgs(): array
    {
        return array_values($this->args);
    }

    function getInputArg(string $name): ?InputArg
    {
        return $this->args[$name];
    }
}