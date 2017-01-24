<?php
namespace CodeClimate\PhpTestReporter\TestReporter;

use CodeClimate\PhpTestReporter\TestReporter\Entity\JsonFile;
use Satooshi\Bundle\CoverallsV1Bundle\Api\Jobs;
use Satooshi\Bundle\CoverallsV1Bundle\Config\Configuration;

class CoverageCollector
{
    /**
     * @var Jobs
     */
    protected $api;

    /**
     * Array that holds list of relative paths to Clover XML files
     * @var array
     */
    protected $cloverPaths = array( );

    /**
     * CoverageCollector constructor.
     *
     * @param string[] $paths
     */
    public function __construct($paths)
    {
        $rootDir = getcwd();
        $config  = new Configuration();
        $config->setRootDir($rootDir);
        $this->setCloverPaths($paths);
        foreach ($this->getCloverPaths() as $path) {
            if (file_exists($path)) {
                $config->addCloverXmlPath($path);
            } else {
                $config->addCloverXmlPath($rootDir . DIRECTORY_SEPARATOR . $path);
            }
        }

        $this->api = new Jobs($config);
    }

    /**
     * Set a list of Clover XML paths
     *
     * @param string[] $paths Array of relative paths to Clovers XML files
     */
    public function setCloverPaths($paths)
    {
        $this->cloverPaths = $paths;
    }

    /**
     * Get a list of Clover XML paths
     * @return string[] Array of relative Clover XML file locations
     */
    public function getCloverPaths()
    {
        return $this->cloverPaths;
    }

    /**
     * @return JsonFile
     */
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
