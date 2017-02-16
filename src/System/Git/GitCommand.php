<?php
namespace CodeClimate\PhpTestReporter\System\Git;

use Satooshi\Component\System\SystemCommand;

class GitCommand extends SystemCommand
{
    protected $commandPath = 'git';

    /**
     * @return GitInfoInterface
     */
    public function getGitInfo()
    {
        return new GitInfo(
            $this->getHead(),
            $this->getBranch(),
            $this->getCommittedAt()
        );
    }

    /**
     * @return string
     */
    private function getHead()
    {
        $command = $this->createCommand("log -1 --pretty=format:'%H'");

        return current($this->executeCommand($command));
    }

    /**
     * @return string|null
     */
    private function getBranch()
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
    private function getCommittedAt()
    {
        $command = $this->createCommand("log -1 --pretty=format:'%ct'");

        return (int)current($this->executeCommand($command));
    }
}
