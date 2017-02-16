<?php

namespace CodeClimate\PhpTestReporter\System\Git;

/**
 * @internal
 */
interface GitInfoInterface
{
    /**
     * @return string
     */
    public function head();

    /**
     * @return string
     */
    public function branch();

    /**
     * @return int
     */
    public function committedAt();

    /**
     * @return array
     */
    public function toArray();
}
