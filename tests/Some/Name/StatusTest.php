<?php

namespace Some\Name;

use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testSuccessfulTestsShowGreenCheckmark()
    {
        $this->assertTrue(true);
    }

    public function testFailingTestsShowRedTimesSign()
    {
        $this->assertFalse(true);
    }

    public function testSkippedTestsShowCyanS()
    {
        $this->markTestSkipped('Skipped to show how it looks');
    }

    public function testIncompleteTestsShowYellowI()
    {
        $this->markTestIncomplete('Nothing done');
    }

    public function testTestsWithoutAssertionsShowYellowR()
    {
        // nothing to see here
    }

    public function testTestsWithErrorsShowRedExclamationMark()
    {
        throw new \Exception('test');
    }
}
