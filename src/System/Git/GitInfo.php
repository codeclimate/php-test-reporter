<?php

namespace CodeClimate\PhpTestReporter\System\Git;

/**
 * @internal
 */
final class GitInfo implements GitInfoInterface
{
    /**
     * @var string
     */
    private $head;

    /**
     * @var string
     */
    private $branch;

    /**
     * @var int
     */
    private $committedAt;

    /**
     * @param string $head
     * @param string|null $branch
     * @param int $committedAt
     */
    public function __construct($head, $branch, $committedAt)
    {
        $this->head = $head;
        $this->branch = $branch;
        $this->committedAt = $committedAt;
    }

    public function head()
    {
        return $this->head;
    }

    public function branch()
    {
        return $this->branch;
    }

    public function committedAt()
    {
        return $this->committedAt;
    }

    public function toArray()
    {
        return array(
            'head' => $this->head,
            'branch' => $this->branch,
            'committed_at' => $this->committedAt,
        );
    }
}
