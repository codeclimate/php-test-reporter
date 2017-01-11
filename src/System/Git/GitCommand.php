<?php
namespace CodeClimate\PhpTestReporter\System\Git;

use Satooshi\Component\System\SystemCommand;

class GitCommand extends SystemCommand
{
    protected $commandPath = 'git';

    /**
     * @return string
     */
    public function getHead()
    {
        $command = $this->createCommand("log -1 --pretty=format:'%H'");

        return current($this->executeCommand($command));
    }

    /**
     * @return string|null
     */
    public function getBranch()
    {
        $command  = $this->createCommand("branch");
        $branches = $this->executeCommand($command);

        foreach ($branches as $branch) {
            if ($branch[0] == "*") {
                return str_replace("* ", "", $branch);
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getCommittedAt()
    {
        $command = $this->createCommand("log -1 --pretty=format:'%ct'");

        return (int)current($this->executeCommand($command));
    }
}
