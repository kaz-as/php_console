<?php

namespace Commands;

use Console\Io\InputInterface;
use Console\Io\OutputInterface;

/**
 * Тестовая команда. Выводит все входящие параметры команды.
 */
class ShowInputArgs implements \Console\Command
{

    function getName(): string
    {
        return 'command_name';
    }

    function getDescription(): string
    {
        return 'Shows all arguments and parameters of the current launch';
    }

    function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $input->getInputArgs();
        $arguments = [];
        $options = [];
        foreach ($args as $arg) {
            if ($arg->isArgument()) {
                $arguments[] = $arg;
            } else {
                $options[] = $arg;
            }
        }
        $output->out("Called command: {$this->getName()}");

        if ($arguments) {
            $output->out();
            $output->out('Arguments:');
            foreach ($arguments as $argument) {
                $output->out("   - {$argument->getName()}");
            }
        }

        if ($options) {
            $output->out();
            $output->out('Arguments:');
            foreach ($options as $option) {
                $output->out("   - {$option->getName()}");
                if (!$option->getValues()) {
                    continue;
                }
                foreach ($option->getValues() as $value) {
                    $output->out("         - $value");
                }
            }
        }
    }
}