<?php
namespace CodeClimate\Bundle\TestReporterBundle\Entity;

use CodeClimate\Component\System\Git\GitCommand;
use CodeClimate\Bundle\TestReporterBundle\Entity\CiInfo;
use CodeClimate\Bundle\TestReporterBundle\Version;

class JsonFile extends \Satooshi\Bundle\CoverallsV1Bundle\Entity\JsonFile
{
    public function toArray()
    {
       return array(
            "partial"     => false,
            "run_at"      => $this->getRunAt(),
            "repo_token"  => $this->getRepoToken(),
            "environment" => $this->getEnvironment(),
            "git"         => $this->collectGitInfo(),
            "ci_service"  => $this->collectCiServiceInfo(),
            "sourceFiles" => $this->collectSourceFiles()
        );
    }

    public function getRunAt()
    {
        // TODO: parse date and return as unix seconds
        return parent::getRunAt();
    }

    public function getRepoToken()
    {
        return $_SERVER["CODECLIMATE_REPO_TOKEN"];
    }

    protected function getEnvironment()
    {
        return array(
            "pwd"             => getcwd(),
            "package_version" => Version::VERSION
        );
    }

    protected function collectGitInfo()
    {
        $command = new GitCommand();

        return array(
            "head"         => $command->getHead(),
            "branch"       => $command->getBranch(),
            "committed_at" => $command->getCommittedAt()
        );
    }

    protected function collectCiServiceInfo()
    {
        $ciInfo = new CiInfo();

        return $ciInfo->toArray();
    }

    protected function collectSourceFiles()
    {
        $sourceFiles = array();

        foreach ($this->getSourceFiles() as $sourceFile)
        {
            array_push($sourceFiles, array(
                "name"     => $sourceFile->getName(),
                "coverage" => $sourceFile->getCoverage(),
                "blob_id"  => $this->calculateBlobId($sourceFile)
            ));
        }

        return $sourceFiles;
    }

    protected function calculateBlobId($sourceFile)
    {
        $content = file_get_contents($sourceFile->getPath());

        return sha1("blob ".$content."\0");
    }
}
