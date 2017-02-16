<?php

namespace CodeClimate\PhpTestReporter\Tests\Unit\System\Git;

use CodeClimate\PhpTestReporter\System\Git\GitInfo;

class GitInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testIsFinal()
    {
        $reflection = new \ReflectionClass('CodeClimate\PhpTestReporter\System\Git\GitInfo');

        $this->assertTrue($reflection->isFinal());
    }

    public function testImplementsGitInfoInterface()
    {
        $reflection = new \ReflectionClass('CodeClimate\PhpTestReporter\System\Git\GitInfo');

        $this->assertTrue($reflection->implementsInterface('CodeClimate\PhpTestReporter\System\Git\GitInfoInterface'));
    }

    public function testConstructorSetsValues()
    {
        $head = 'foo';
        $branch = 'feature/gitinfo';
        $committedAt = time();

        $info = new GitInfo(
            $head,
            $branch,
            $committedAt
        );

        $this->assertSame($head, $info->head());
        $this->assertSame($branch, $info->branch());
        $this->assertSame($committedAt, $info->committedAt());
    }

    public function testToArrayReturnsArrayRepresentation()
    {
        $head = 'foo';
        $branch = 'feature/gitinfo';
        $committedAt = time();

        $info = new GitInfo(
            $head,
            $branch,
            $committedAt
        );

        $expected = array(
            'head' => $head,
            'branch' => $branch,
            'committed_at' => $committedAt,
        );

        $this->assertEquals($expected, $info->toArray());
    }
}
