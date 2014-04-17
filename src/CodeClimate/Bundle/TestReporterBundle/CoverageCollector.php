<?php
namespace CodeClimate\Bundle\TestReporterBundle;

use CodeClimate\Component\System\Git\GitCommand;
use CodeClimate\Bundle\TestReporterBundle\Entity\JsonFile;
use Satooshi\Bundle\CoverallsV1Bundle\Api\Jobs;
use Satooshi\Bundle\CoverallsV1Bundle\Config\Configuration;

class CoverageCollector
{
    const RELATIVE_PATH = 'build/logs/clover.xml';

    protected $api;

    public function __construct()
    {
        $rootDir = getcwd();
        $config = new Configuration();
        $config->setSrcDir($rootDir);
        $config->addCloverXmlPath($rootDir . DIRECTORY_SEPARATOR . static::RELATIVE_PATH);

        $this->api = new Jobs($config);
    }

    public function collectAsJson()
    {
        $cloverJsonFile = $this->api->collectCloverXml()->getJsonFile();

        $jsonFile = new JsonFile();
        $jsonFile->setRunAt($cloverJsonFile->getRunAt());

        foreach ($cloverJsonFile->getSourceFiles() as $sourceFile)
        {
            $jsonFile->addSourceFile($sourceFile);
        }

        return $jsonFile;
    }
}
