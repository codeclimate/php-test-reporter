<?php
namespace CodeClimate\Bundle\TestReporterBundle;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class ApiClient
{
    protected $client;
    protected $apiHost;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiHost = "https://codeclimate.com";

        if (isset($_SERVER["CODECLIMATE_API_HOST"])) {
          $this->apiHost = $_SERVER["CODECLIMATE_API_HOST"];
        }

    }

    public function send($json)
    {
        $request = $this->client->createRequest('POST', $this->apiHost."/test_reports");
        $response = false;

        $request->setHeader("User-Agent", "Code Climate (PHP Test Reporter v".Version::VERSION.")");
        $request->setHeader("Content-Type", "application/json");
        $request->setBody($json);

        try {
            $response = $this->client->send($request);
        } catch (ClientErrorResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}
