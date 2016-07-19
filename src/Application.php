<?php
namespace CodeClimate\PhpTestReporter;

use CodeClimate\PhpTestReporter\ConsoleCommands\TestReporterCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Coveralls API application.
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class Application extends BaseApplication
{
	// internal method

    /**
     * {@inheritdoc}
     * @see \Symfony\Component\Console\Application::getCommandName()
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'test-reporter';
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Component\Console\Application::getDefaultCommands()
     */
    protected function getDefaultCommands()
    {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands   = parent::getDefaultCommands();
        $defaultCommands[] = $this->createTestReporterCommand();

        return $defaultCommands;
    }

	/**
	 * Create TestReporterCommand.
	 * @return TestReporterCommand
	 */
	protected function createTestReporterCommand()
	{
		$command = new TestReporterCommand();

        return $command;
    }

    // accessor

    /**
     * {@inheritdoc}
     * @see \Symfony\Component\Console\Application::getDefinition()
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
