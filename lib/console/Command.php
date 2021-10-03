<?php

namespace Console;

use Console\Io\InputInterface;
use Console\Io\OutputInterface;

interface Command
{
    function getName(): string;
    function getDescription(): string;
    function execute(InputInterface $input, OutputInterface $output);
}