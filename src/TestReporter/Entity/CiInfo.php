<?php
namespace CodeClimate\PhpTestReporter\TestReporter\Entity;

class CiInfo
{
    /**
     * @var array
     */
    private $info;

    public function __construct(array $server)
    {
        $this->info = $this->infoFrom($server);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->info;
    }

    /**
     * @param array $server
     * @return array
     */
    private function infoFrom(array $server)
    {
        if (isset($server["TRAVIS"])) {
            return $this->travisProperties($server);
        }

        if (isset($server["CIRCLECI"])) {
            return $this->circleProperties($server);
        }

        if (isset($server["SEMAPHORE"])) {
            return $this->semaphoreProperties($server);
        }

        if (isset($server["JENKINS_URL"])) {
            return $this->jenkinsProperties($server);
        }

        if (isset($server["TDDIUM"])) {
            return $this->tddiumProperties($server);
        }

        if (isset($server["CI_NAME"]) && false !== stripos($server["CI_NAME"], 'codeship')) {
            return $this->codeshipProperties($server);
        }

        if (isset($server["BUILDKITE"])) {
            return $this->buildkiteProperties($server);
        }

        if (isset($server["WERCKER"])) {
            return $this->werckerProperties($server);
        }

        if (isset($server["GITLAB_CI"])) {
            return $this->gitlabCiProperties($server);
        }

        return array();
    }

    /**
     * @param array $server
     * @return array
     */
    protected function travisProperties(array $server)
    {
        return array(
            "name"             => "travis-ci",
            "branch"           => $server["TRAVIS_BRANCH"],
            "build_identifier" => $server["TRAVIS_JOB_ID"],
            "pull_request"     => $server["TRAVIS_PULL_REQUEST"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function circleProperties(array $server)
    {
        return array(
            "name"             => "circleci",
            "build_identifier" => $server["CIRCLE_BUILD_NUM"],
            "branch"           => $server["CIRCLE_BRANCH"],
            "commit_sha"       => $server["CIRCLE_SHA1"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function semaphoreProperties(array $server)
    {
        return array(
            "name"             => "semaphore",
            "branch"           => $server["BRANCH_NAME"],
            "build_identifier" => $server["SEMAPHORE_BUILD_NUMBER"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function jenkinsProperties(array $server)
    {
        return array(
            "name"             => "jenkins",
            "build_identifier" => $server["BUILD_NUMBER"],
            "build_url"        => $server["BUILD_URL"],
            "branch"           => $server["GIT_BRANCH"],
            "commit_sha"       => $server["GIT_COMMIT"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function tddiumProperties(array $server)
    {
        return array(
            "name"             => "tddium",
            "build_identifier" => $server["TDDIUM_SESSION_ID"],
            "worker_id"        => $server["TDDIUM_TID"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function codeshipProperties(array $server)
    {
        return array(
            "name"             => "codeship",
            "build_identifier" => $server["CI_BUILD_NUMBER"],
            "build_url"        => $server["CI_BUILD_URL"],
            "branch"           => $server["CI_BRANCH"],
            "commit_sha"       => $server["CI_COMMIT_ID"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function buildkiteProperties(array $server)
    {
        return array(
            "name"             => "buildkite",
            "build_identifier" => $server["BUILDKITE_BUILD_ID"],
            "build_url"        => $server["BUILDKITE_BUILD_URL"],
            "branch"           => $server["BUILDKITE_BRANCH"],
            "commit_sha"       => $server["BUILDKITE_COMMIT"],
            "pull_request"     => $server["BUILDKITE_PULL_REQUEST"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function werckerProperties(array $server)
    {
        return array(
            "name"             => "wercker",
            "build_identifier" => $server["WERCKER_BUILD_ID"],
            "build_url"        => $server["WERCKER_BUILD_URL"],
            "branch"           => $server["WERCKER_GIT_BRANCH"],
            "commit_sha"       => $server["WERCKER_GIT_COMMIT"],
        );
    }

    /**
     * @param array $server
     * @return array
     */
    protected function gitlabCiProperties(array $server)
    {
        return array(
            "name"             => "gitlab-ci",
            "build_identifier" => $server["CI_BUILD_ID"],
            "branch"           => $server["CI_BUILD_REF_NAME"],
            "commit_sha"       => $server["CI_BUILD_REF"],
        );
    }
}
