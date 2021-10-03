<?php

namespace Console\Io;

class Parameter
{
    /**
     * @param string $name
     * @param string[] $values
     * @param bool $soleValue
     * @throws InputException
     */
    function __construct(
        private string $name,
        private array $values,
        private bool $soleValue,
    ) {
        if ($this->soleValue && count($this->values) != 1) {
            throw new InputException("Bad values of parameter '$this->name'");
        }
    }

    function getName(): string
    {
        return $this->name;
    }

    function isSoleValue(): bool
    {
        return $this->soleValue;
    }

    function getValues(): array
    {
        return $this->values;
    }
}