<?php
namespace CodeClimate\PhpTestReporter;

use CodeClimate\PhpTestReporter\ConsoleCommands\UploadCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Coveralls API application.
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class Application extends BaseApplication
{
    // internal method

    protected function getCommandName(InputInterface $input)
    {
        return 'upload';
    }

    protected function getDefaultCommands()
    {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands   = parent::getDefaultCommands();
        $defaultCommands[] = $this->createUploadCommand();

        return $defaultCommands;
    }

    /**
     * Create UploadCommand.
     * @return UploadCommand
     */
    protected function createUploadCommand()
    {
        return new UploadCommand('upload');
    }

    // accessor

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
