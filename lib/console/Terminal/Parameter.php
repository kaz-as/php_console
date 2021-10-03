<?php

namespace Console\Terminal;

use Console\Io\InputArg;
use Console\Io\InputException;

/** Входящий параметр, как он приходит из консоли */
class Parameter implements InputArg
{
    /**
     * @param string $name
     * @param bool $isArgument Истина — аргумент, ложь — параметр
     * @param string[] $values
     * @param bool $soleValue
     * @throws InputException
     */
    protected function __construct(
        private string $name,
        private bool $isArgument,
        private ?array $values = null,
        private ?bool $soleValue = null,
    ) {
        if ($this->isArgument && $this->soleValue !== null) {
            throw new InputException("Cannot set sole value status for argument ($this->name), " .
                "because it has not values");
        }
        if (!$this->isArgument && $this->soleValue && count($this->values) != 1) {
            throw new InputException("Bad values of parameter '$this->name'");
        }
    }

    function getName(): string
    {
        return $this->name;
    }

    /**
     * Если это аргумент, то null.
     * Если значение параметра единственно, это может быть [p={v}], тогда ложь, или [p=v], тогда истина.
     */
    function isSoleValue(): ?bool
    {
        return $this->soleValue;
    }

    function isArgument(): bool
    {
        return $this->isArgument;
    }

    function getValues(): ?array
    {
        return $this->values;
    }

    protected const DELIMITER = ',';
    protected const ARGUMENT_START = '{';
    protected const ARGUMENT_END = '}';
    protected const PARAMETER_START = '[';
    protected const PARAMETER_END = ']';
    protected const PARAMETER_EQUALS = '=';

    /**
     * @return string[]
     * @throws InputException
     */
    protected static function parseArguments(string $s, int &$currentPos): array
    {
        $arguments = [];
        $word = '';
        $badSymbols = [
            static::ARGUMENT_START => true,
            static::PARAMETER_START => true,
            static::PARAMETER_END => true,
            static::PARAMETER_EQUALS => true,
        ];
        for (; $currentPos < strlen($s); $currentPos++) {
            $c = $s[$currentPos];
            if ($c == static::DELIMITER || $c == static::ARGUMENT_END) {
                if (!$word) {
                    throw new InputException('Empty argument');
                }
                $arguments[] = $word;
                $word = '';
                if ($c == static::ARGUMENT_END) {
                    $currentPos++;
                    return $arguments;
                }
            } elseif (isset($badSymbols[$c])) {
                throw new InputException("Unexpected '$c' while argument parsing");
            } else {
                $word .= $c;
            }
        }
        throw new InputException('Expected \''.static::ARGUMENT_END.'\', got end of string');
    }

    /**
     * @param string $s
     * @param int $currentPos
     * @return array<string, string[]|string>
     * @throws InputException
     */
    protected static function parseParameters(string $s, int &$currentPos): array
    {
        $name = '';
        $badSymbols = [
            static::DELIMITER => true,
            static::ARGUMENT_END => true,
            static::ARGUMENT_START => true,
            static::PARAMETER_START => true,
            static::PARAMETER_END => true,
        ];
        for (; $currentPos < strlen($s); $currentPos++) {
            $c = $s[$currentPos];
            if ($c == static::PARAMETER_EQUALS) {
                $currentPos++;
                break;
            }
            if (isset($badSymbols[$c])) {
                throw new InputException("Unexpected '$c' while argument parsing");
            }
            $name .= $c;
        }
        if ($currentPos == strlen($s)) {
            throw new InputException('Expected \''.static::PARAMETER_EQUALS.'\', got end of string');
        }

        if ($s[$currentPos] == static::ARGUMENT_START) {
            $currentPos++;
            $args = self::parseArguments($s, $currentPos);
            $currentPos++;
            return [$name => $args];
        }

        $word = '';
        $badSymbols = [
            static::DELIMITER => true,
            static::ARGUMENT_END => true,
            static::ARGUMENT_START => true,
            static::PARAMETER_START => true,
            static::PARAMETER_EQUALS => true,
        ];
        for (; $currentPos < strlen($s); $currentPos++) {
            $c = $s[$currentPos];
            if ($c == static::PARAMETER_END) {
                if (!$word) {
                    throw new InputException('Empty parameter');
                }
                $currentPos++;
                return [$name => $word];
            }
            if (isset($badSymbols[$c])) {
                throw new InputException("Unexpected '$c' while argument parsing");
            }
            $word .= $c;
        }

        throw new InputException('Expected \''.static::PARAMETER_END.'\', got end of string');
    }

    /**
     * @throws InputException
     */
    static function parse(string $s): array
    {
        $nextPosition = 1;
        if ($s[0] == static::ARGUMENT_START) {
            $argumentStrings = static::parseArguments($s, $nextPosition);
            if ($nextPosition != strlen($s)) {
                throw new InputException('Only space is allowed after \'' . static::ARGUMENT_END
                    . '\' if it is an argument');
            }
            $arguments = [];
            foreach ($argumentStrings as $str) {
                $arguments[] = new static($str, true);
            }
            return $arguments;
        }
        if ($s[0] == static::PARAMETER_START) {
            $p = static::parseParameters($s, $nextPosition);
            if ($nextPosition != strlen($s)) {
                throw new InputException('Only space is allowed after \'' . static::PARAMETER_END
                    . '\' if it is a parameter');
            }
            $pv = current($p);
            return [new static(
                key($p),
                false,
                is_array($pv) ? $pv : [$pv],
                !is_array($pv)
            )];
        }

        $badSymbols = [
            static::DELIMITER => true,
            static::ARGUMENT_END => true,
            static::ARGUMENT_START => true,
            static::PARAMETER_START => true,
            static::PARAMETER_END => true,
            static::PARAMETER_EQUALS => true,
        ];
        for ($i = 0; $i < strlen($s); $i++){
             if (isset($badSymbols[$s[$i]])) {
                 throw new InputException("Bad agrument: '$s'");
             }
        }
        return [new static($s, true)];
    }
}