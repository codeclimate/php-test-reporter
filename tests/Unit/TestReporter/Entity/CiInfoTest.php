<?php

namespace CodeClimate\PhpTestReporter\Tests\Unit\TestReporter\Entity;

use CodeClimate\PhpTestReporter\TestReporter\Entity\CiInfo;

final class CiInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testToArrayReturnsEmptyArrayIfUnableToDetermineEnvironment()
    {
        $server = array(
            'foo' => 'bar',
        );

        $info = new CiInfo($server);

        $expected = array();

        $this->assertSame($expected, $info->toArray());
    }

    public function testToArrayReturnsTravisCiProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $pullRequest = false;

        $server = array(
            'TRAVIS' => true,
            'TRAVIS_BRANCH' => $branch,
            'TRAVIS_JOB_ID' => $buildIdentifier,
            'TRAVIS_PULL_REQUEST' => $pullRequest,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'travis-ci',
            'branch' => $branch,
            'build_identifier' => $buildIdentifier,
            'pull_request' => $pullRequest,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    public function testToArrayReturnsSemaphoreProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;

        $server = array(
            'SEMAPHORE' => true,
            'BRANCH_NAME' => $branch,
            'SEMAPHORE_BUILD_NUMBER' => $buildIdentifier,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'semaphore',
            'branch' => $branch,
            'build_identifier' => $buildIdentifier,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    public function testToArrayReturnsJenkinsProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $buildUrl = 'http://example.orf/foo/bar';
        $commitSha = \sha1('foo');

        $server = array(
            'JENKINS_URL' => 'http://example.org',
            'BUILD_NUMBER' => $buildIdentifier,
            'BUILD_URL' => $buildUrl,
            'GIT_BRANCH' => $branch,
            'GIT_COMMIT' => $commitSha,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'jenkins',
            'branch' => $branch,
            'build_identifier' => $buildIdentifier,
            'build_url' => $buildUrl,
            'commit_sha' => $commitSha,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    public function testToArrayReturnsTddiumProperties()
    {
        $sessionId = 9000;
        $workerId = 12;

        $server = array(
            'TDDIUM' => true,
            'TDDIUM_SESSION_ID' => $sessionId,
            'TDDIUM_TID' => $workerId,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'tddium',
            'build_identifier' => $sessionId,
            'worker_id' => $workerId,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    /**
     * @dataProvider providerCodeshipName
     */
    public function testToArrayReturnsCodeshipProperties($ciName)
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $buildUrl = 'http://example.orf/foo/bar';
        $commitSha = \sha1('foo');

        $server = array(
            'CI_NAME' => $ciName,
            'CI_BRANCH' => $branch,
            'CI_COMMIT_ID' => $commitSha,
            'CI_BUILD_NUMBER' => $buildIdentifier,
            'CI_BUILD_URL' => $buildUrl,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'codeship',
            'build_identifier' => $buildIdentifier,
            'build_url' => $buildUrl,
            'branch' => $branch,
            'commit_sha' => $commitSha,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    /**
     * @return array
     */
    public function providerCodeshipName()
    {
        $names = array(
            'codeship',
            'CODESHIP',
            'best-codeship-3000',
            'best-CODESHIP-3000',
        );

        return \array_map(function ($name) {
            return array(
                $name,
            );
        }, $names);
    }

    public function testToArrayReturnsBuildkiteProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $buildUrl = 'http://example.orf/foo/bar';
        $commitSha = \sha1('foo');
        $pullRequest = false;

        $server = array(
            'BUILDKITE' => true,
            'BUILDKITE_BRANCH' => $branch,
            'BUILDKITE_BUILD_ID' => $buildIdentifier,
            'BUILDKITE_BUILD_URL' => $buildUrl,
            'BUILDKITE_COMMIT' => $commitSha,
            'BUILDKITE_PULL_REQUEST' => $pullRequest,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'buildkite',
            'build_identifier' => $buildIdentifier,
            'build_url' => $buildUrl,
            'branch' => $branch,
            'commit_sha' => $commitSha,
            'pull_request' => $pullRequest,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    public function testToArrayReturnsGitlabCiProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $commitSha = \sha1('foo');

        $server = array(
            'CI' => true,
            'GITLAB_CI' => true,
            'CI_BUILD_REF' => $commitSha,
            'CI_BUILD_REF_NAME' => $branch,
            'CI_BUILD_ID' => $buildIdentifier,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'gitlab-ci',
            'build_identifier' => $buildIdentifier,
            'branch' => $branch,
            'commit_sha' => $commitSha,
        );

        $this->assertEquals($expected, $info->toArray());
    }

    public function testToArrayReturnsWerckerProperties()
    {
        $branch = 'fix/test';
        $buildIdentifier = 9000;
        $buildUrl = 'http://example.orf/foo/bar';
        $commitSha = \sha1('foo');

        $server = array(
            'WERCKER' => true,
            'WERCKER_BUILD_ID' => $buildIdentifier,
            'WERCKER_BUILD_URL' => $buildUrl,
            'WERCKER_GIT_BRANCH' => $branch,
            'WERCKER_GIT_COMMIT' => $commitSha,
        );

        $info = new CiInfo($server);

        $expected = array(
            'name' => 'wercker',
            'build_identifier' => $buildIdentifier,
            'build_url' => $buildUrl,
            'branch' => $branch,
            'commit_sha' => $commitSha,
        );

        $this->assertEquals($expected, $info->toArray());
    }
}
