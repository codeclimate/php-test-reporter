<?php
/**
 * @author hollodotme
 */

namespace CodeClimate\PhpTestReporter\ConsoleCommands;

use CodeClimate\PhpTestReporter\Constants\PharTool;
use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RollbackCommand
 * @package CodeClimate\PhpTestReporter\ConsoleCommands
 */
class RollbackCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Rolls back this PHAR to the previous version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->validate();
        $logger  = new ConsoleLogger($output);
        $updater = new Updater(null, false, Updater::STRATEGY_GITHUB);

        /** @var GithubStrategy $strategy */
        $strategy = $updater->getStrategy();

        $strategy->setPackageName(PharTool::PACKAGE_NAME);
        $strategy->setPharName(PharTool::PHAR_NAME);
        $strategy->setCurrentLocalVersion('@package_version@');

        if ($updater->rollback()) {
            $logger->info('Roll back successful!');
        } else {
            $logger->alert('Roll back failed.');
        }

        return 0;
    }
}
