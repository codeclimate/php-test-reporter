<?php
namespace CodeClimate\Bundle\TestReporterBundle\Command;

use CodeClimate\Bundle\TestReporterBundle\CoverageCollector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test reporter command
 */
class TestReporterCommand extends Command
{
    /**
     * Path to project root directory.
     *
     * @var string
     */
    protected $rootDir;

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
        ->setName('test-reporter')
        ->setDescription('Code Climate PHP Test Reporter')
        ->addOption(
            'stdout',
            null,
            InputOption::VALUE_NONE,
            'Do not upload, print JSON payload to stdout'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collector = new CoverageCollector();
        $json = $collector->collectAsJson();

        if ($input->getOption('stdout'))
        {
            $output->writeln((string)$json);
        } else {
            // TODO: Upload to CC API
        }

        return 0;
    }

    // accessor

    /**
     * Set root directory.
     *
     * @param string $rootDir Path to project root directory.
     *
     * @return void
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }
}
