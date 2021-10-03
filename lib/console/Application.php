<?php

namespace Console;

use Console\Io\InputException;
use Console\Io\InputInterface;
use Console\Io\OutputInterface;
use Console\Terminal\Input;
use Console\Terminal\Output;

class Application
{
    /**
     * Названия команд выступают в роли ключей
     * @var array<string, Command>
     */
    private array $commands;

    function __construct(
        private string $argHelp = 'help',
        private ?InputInterface $input = null,
        private ?OutputInterface $output = null,
    ) {
        if (!$this->input) {
            $this->setInput(new Input());
        }
        if (!$this->output) {
            $this->setOutput(new Output());
        }
    }

    function setInput(InputInterface $input)
    {
        $this->input = $input;
    }

    function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    function add(Command $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    /**
     * @throws InputException
     */
    function run()
    {
        $name = $this->input->getCommand();

        if (!$name) {
            $this->output->out('Registered commands:');
            foreach ($this->commands as $command) {
                $this->output->out("----  {$command->getName()}");
                $this->output->out("      {$command->getDescription()}");
            }
            return;
        }

        if (empty($this->commands[$name])) {
            throw new InputException("Command name '$name' is not registered");
        }

        if ($this->input->getInputArg($this->argHelp)?->isArgument()) {
            $this->output->out($this->commands[$name]->getDescription());
        } else {
            $this->commands[$name]->execute($this->input, $this->output);
        }
    }
}