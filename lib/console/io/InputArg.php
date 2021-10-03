<?php

namespace Console\Io;

/** Входной параметр */
interface InputArg
{
    function getName(): string;
    /** Аргумент - истина, параметр - ложь */
    function isArgument(): bool;
    /** null, если значения не предусмотрены */
    function getValues(): ?array;
    /** @return static[] */
    static function parse(string $s): array;
}
