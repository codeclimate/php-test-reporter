<?php
namespace CodeClimate\Bundle\TestReporterBundle;

class ApiClient
{
    protected $apiHost;

    public function __construct()
    {
        $this->apiHost = "https://codeclimate.com";

        if (isset($_SERVER["CODECLIMATE_API_HOST"])) {
            $this->apiHost = $_SERVER["CODECLIMATE_API_HOST"];
        }

    }

    public function send($json)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_URL => $this->apiHost.'/test_reports',
            CURLOPT_USERAGENT => 'Code Climate (PHP Test Reporter v'.Version::VERSION.')',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => (string)$json,
        ));

        $response = new \stdClass;
        if ($raw_response = curl_exec($ch)) {
            $this->buildResponse($response, $raw_response);

            while ($response->code == 100) { // Continue
                $this->buildResponse($response, $response->body);
            }
        } else {
            $response->code = -curl_errno($ch);
            $response->message = curl_error($ch);
            $response->headers = array();
            $response->body = NULL;
        }
        curl_close($ch);

        return $response;
    }

    private function buildResponse($response, $body)
    {
        list($response->headers, $response->body) = explode("\r\n\r\n", $body, 2);
        $response->headers = explode("\r\n", $response->headers);
        list(, $response->code, $response->message) = explode(' ', $response->headers[0], 3);
    }
}
