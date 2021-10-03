<?php

namespace Console;

use Console\Io\InputInterface;
use Console\Io\OutputInterface;

/** Все команды наследуются отсюда */
interface Command
{
    /** Имя */
    function getName(): string;
    /** Описание */
    function getDescription(): string;
    /** Действия */
    function execute(InputInterface $input, OutputInterface $output);
}