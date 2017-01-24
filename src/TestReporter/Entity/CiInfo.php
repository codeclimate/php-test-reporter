<?php
namespace CodeClimate\PhpTestReporter\TestReporter\Entity;

class CiInfo
{
    /**
     * @return array
     */
    public function toArray()
    {
        if (isset($_SERVER["TRAVIS"])) {
            return $this->travisProperties();
        }

        if (isset($_SERVER["CIRCLECI"])) {
            return $this->circleProperties();
        }

        if (isset($_SERVER["SEMAPHORE"])) {
            return $this->semaphoreProperties();
        }

        if (isset($_SERVER["JENKINS_URL"])) {
            return $this->jenkinsProperties();
        }

        if (isset($_SERVER["TDDIUM"])) {
            return $this->tddiumProperties();
        }

        if (isset($_SERVER["CI_NAME"]) && false !== stripos($_SERVER["CI_NAME"], 'codeship')) {
            return $this->codeshipProperties();
        }

        if (isset($_SERVER["BUILDKITE"])) {
            return $this->buildkiteProperties();
        }

        if (isset($_SERVER["WERCKER"])) {
            return $this->werckerProperties();
        }

        return array( );
    }

    /**
     * @return array
     */
    protected function travisProperties()
    {
        return array(
            "name"             => "travis-ci",
            "branch"           => $_SERVER["TRAVIS_BRANCH"],
            "build_identifier" => $_SERVER["TRAVIS_JOB_ID"],
            "pull_request"     => $_SERVER["TRAVIS_PULL_REQUEST"],
        );
    }

    /**
     * @return array
     */
    protected function circleProperties()
    {
        return array(
            "name"             => "circleci",
            "build_identifier" => $_SERVER["CIRCLE_BUILD_NUM"],
            "branch"           => $_SERVER["CIRCLE_BRANCH"],
            "commit_sha"       => $_SERVER["CIRCLE_SHA1"],
        );
    }

    /**
     * @return array
     */
    protected function semaphoreProperties()
    {
        return array(
            "name"             => "semaphore",
            "branch"           => $_SERVER["BRANCH_NAME"],
            "build_identifier" => $_SERVER["SEMAPHORE_BUILD_NUMBER"],
        );
    }

    /**
     * @return array
     */
    protected function jenkinsProperties()
    {
        return array(
            "name"             => "jenkins",
            "build_identifier" => $_SERVER["BUILD_NUMBER"],
            "build_url"        => $_SERVER["BUILD_URL"],
            "branch"           => $_SERVER["GIT_BRANCH"],
            "commit_sha"       => $_SERVER["GIT_COMMIT"],
        );
    }

    /**
     * @return array
     */
    protected function tddiumProperties()
    {
        return array(
            "name"             => "tddium",
            "build_identifier" => $_SERVER["TDDIUM_SESSION_ID"],
            "worker_id"        => $_SERVER["TDDIUM_TID"],
        );
    }

    /**
     * @return array
     */
    protected function codeshipProperties()
    {
        return array(
            "name"             => "codeship",
            "build_identifier" => $_SERVER["CI_BUILD_NUMBER"],
            "build_url"        => $_SERVER["CI_BUILD_URL"],
            "branch"           => $_SERVER["CI_BRANCH"],
            "commit_sha"       => $_SERVER["CI_COMMIT_ID"],
        );
    }

    /**
     * @return array
     */
    protected function buildkiteProperties()
    {
        return array(
            "name"             => "buildkite",
            "build_identifier" => $_SERVER["BUILDKITE_BUILD_ID"],
            "build_url"        => $_SERVER["BUILDKITE_BUILD_URL"],
            "branch"           => $_SERVER["BUILDKITE_BRANCH"],
            "commit_sha"       => $_SERVER["BUILDKITE_COMMIT"],
            "pull_request"     => $_SERVER["BUILDKITE_PULL_REQUEST"],
        );
    }

    /**
     * @return array
     */
    protected function werckerProperties()
    {
        return array(
            "name"             => "wercker",
            "build_identifier" => $_SERVER["WERCKER_BUILD_ID"],
            "build_url"        => $_SERVER["WERCKER_BUILD_URL"],
            "branch"           => $_SERVER["WERCKER_GIT_BRANCH"],
            "commit_sha"       => $_SERVER["WERCKER_GIT_COMMIT"],
        );
    }
}
