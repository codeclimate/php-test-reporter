<?php
namespace CodeClimate\Bundle\TestReporterBundle;

use CodeClimate\Component\System\Git\GitCommand;
use CodeClimate\Bundle\TestReporterBundle\Entity\JsonFile;
use Satooshi\Bundle\CoverallsV1Bundle\Api\Jobs;
use Satooshi\Bundle\CoverallsV1Bundle\Config\Configuration;

class CoverageCollector
{
    // const RELATIVE_PATH = 'build/logs/clover.xml';

    protected $api;
    protected $cloverPaths = array();

    public function __construct($paths)
    {
        $rootDir = getcwd();
        $config = new Configuration();
        $config->setSrcDir($rootDir);
        $this->setCloverPaths($paths);
        foreach ($this->getCloverPaths() as $path) {
            $config->addCloverXmlPath($rootDir . DIRECTORY_SEPARATOR . $path);
        }

        $this->api = new Jobs($config);
    }

    public function setCloverPaths($paths)
    {
        $this->cloverPaths = $paths;
    }

    public function getCloverPaths()
    {
        return $this->cloverPaths;
    }

    public function collectAsJson()
    {
        $cloverJsonFile = $this->api->collectCloverXml()->getJsonFile();

        $jsonFile = new JsonFile();
        $jsonFile->setRunAt($cloverJsonFile->getRunAt());

        foreach ($cloverJsonFile->getSourceFiles() as $sourceFile) {
            $jsonFile->addSourceFile($sourceFile);
        }

        return $jsonFile;
    }
}
