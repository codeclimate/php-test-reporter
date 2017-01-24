<?php

namespace CodeClimate\PhpTestReporter\ConsoleCommands;

use CodeClimate\PhpTestReporter\TestReporter\ApiClient;
use CodeClimate\PhpTestReporter\TestReporter\CoverageCollector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test reporter command
 */
class UploadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setDescription('Uploads test report to code climate')
            ->addOption(
                'stdout',
                null,
                InputOption::VALUE_NONE,
                'Do not upload, print JSON payload to stdout'
            )
            ->addOption(
                'coverage-report',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Location of clover style CodeCoverage report, as produced by PHPUnit\'s --coverage-clover option.',
                array( 'build/logs/clover.xml' )
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collector = new CoverageCollector($input->getOption('coverage-report'));
        $json      = $collector->collectAsJson();

        if ($input->getOption('stdout')) {
            $output->writeln((string)$json);

            return 0;
        }

        $client   = new ApiClient();
        $response = $client->send($json);

        if ($response->code == 200) {
            $output->writeln("Test coverage data sent.");

            return 0;
        }

        if ($response->code == 401) {
            $output->writeln("Invalid CODECLIMATE_REPO_TOKEN.");

            return 1;
        }

        $output->writeln("Unexpected response: " . $response->code . " " . $response->message);
        $output->writeln($response->body);

        return 1;
    }
}
