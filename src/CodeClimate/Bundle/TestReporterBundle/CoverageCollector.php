<?php
namespace CodeClimate\Bundle\TestReporterBundle;

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
        $jsonFile = $this->api->collectCloverXml()->getJsonFile();

        $this->api->collectGitInfo();
        $this->api->collectEnvVars($_SERVER);

        return $jsonFile;
    }
}
