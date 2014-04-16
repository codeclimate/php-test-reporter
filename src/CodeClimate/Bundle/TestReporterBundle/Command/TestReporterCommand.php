<?php
namespace CodeClimate\Bundle\TestReporterBundle\Command;

/* use Satooshi\Bundle\CoverallsV1Bundle\Api\Jobs; */
/* use Satooshi\Bundle\CoverallsV1Bundle\Config\Configuration; */
/* use Satooshi\Bundle\CoverallsV1Bundle\Config\Configurator; */
/* use Satooshi\Bundle\CoverallsV1Bundle\Repository\JobsRepository; */
/* use Satooshi\Component\Log\ConsoleLogger; */
/* use Guzzle\Http\Client; */
/* use Psr\Log\NullLogger; */
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
/* use Symfony\Component\Console\Input\InputOption; */
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
        ->setDescription('Code Climate PHP Test Reporter');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO: Parse clover.xml -> Upload to API

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
