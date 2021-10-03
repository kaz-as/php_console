<?php

namespace Console\Io;

interface InputArg
{
    function getName(): string;
    function isArgument(): bool;
    /** null, если значения не предусмотрены */
    function getValues(): ?array;
    /** @return static[] */
    static function parse(string $s): array;
}