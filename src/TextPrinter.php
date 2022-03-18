<?php

namespace PhpUnitPrinter;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\Warning;
use PHPUnit\TextUI\ResultPrinter;

class TextPrinter extends ResultPrinter
{
    /** @var array Replacement symbols for test statuses */
    protected $symbols;

    /** @var string */
    protected $testRow = '';

    /** @var string */
    protected $previousClassName = '';

    /** @var int */
    protected $maxDuration = 1;

    public function __construct(
        $out = null,
        bool $verbose = false,
        string $colors = self::COLOR_DEFAULT,
        bool $debug = false,
        $numberOfColumns = 80,
        bool $reverse = false
    ) {
        parent::__construct($out, $verbose, $colors, $debug, $numberOfColumns, $reverse);
        $this->symbols = [
            'E' => $this->formatWithColor('fg-red', '!'),
            'F' => $this->formatWithColor('fg-red', "\xe2\x9c\x96"),
            'W' => $this->formatWithColor('fg-yellow', 'W'),
            'I' => $this->formatWithColor('fg-yellow', 'I'),
            'R' => $this->formatWithColor('fg-yellow', 'R'),
            'S' => $this->formatWithColor('fg-cyan', 'S'),
            '.' => $this->formatWithColor('fg-green', "\xe2\x9c\x94"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function writeProgress(string $progress): void
    {
        $this->numTestsRun++;
        if (in_array($progress, array_keys($this->symbols))) {
            $progress = $this->symbols[$progress];
        }

        $this->write("  {$progress} {$this->testRow}" . PHP_EOL);
    }
    /**
     * {@inheritdoc}
     */
    public function addError(Test $test, \Throwable $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-red');
        parent::addError($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-red');
        parent::addFailure($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function addWarning(Test $test, Warning $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-yellow');
        parent::addWarning($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function addIncompleteTest(Test $test, \Throwable $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-yellow');
        parent::addIncompleteTest($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function addRiskyTest(Test $test, \Throwable $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-yellow');
        parent::addRiskyTest($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function addSkippedTest(Test $test, \Throwable $e, float $time): void
    {
        $this->buildTestRow($test, $time, 'fg-cyan');
        parent::addSkippedTest($test, $e, $time);
    }
    /**
     * {@inheritdoc}
     */
    public function endTest(Test $test, float $time): void
    {
        $this->buildTestRow($test, $time);
        parent::endTest($test, $time);
    }
    /**
     * {@inheritdoc}
     *
     * We'll handle the coloring ourselves.
     */
    protected function writeProgressWithColor(string $color, string $buffer): void
    {
        $this->writeProgress($buffer);
    }
    /**
     * Formats the results for a single test.
     *
     * @param Test $test
     * @param float $time
     * @param string $color
     */
    protected function buildTestRow(Test $test, float $time, string $color = 'fg-white'): void
    {
        list($className, $methodName) = \PHPUnit\Util\Test::describe($test);
        if ($className != $this->previousClassName) {
            $this->write(PHP_EOL . $this->formatWithColor('fg-magenta', $className) . PHP_EOL);
            $this->previousClassName = $className;
        }

        $testNumberLength = strlen($this->numTests);
        $this->testRow = sprintf(
            "(%{$testNumberLength}d of %d; %s; %s) %s",
            $this->numTestsRun+1,
            $this->numTests,
            $this->formatTestDuration($time),
            $this->formatAssertionCount($test->getNumAssertions()),
            $this->formatWithColor($color, "{$this->formatMethodName($methodName)}")
        );
    }

    /**
     * Makes the method name more readable.
     *
     * @param string $method
     * @return string
     */
    protected function formatMethodName(string $method): string
    {
        $testDescription = ucfirst(
            $this->splitCamels(
                $this->splitSnakes($method)
            )
        );
        if (strncmp($testDescription, 'Test ', 5) === 0) {
            $testDescription = substr($testDescription, 5);
        }
        return $testDescription;
    }

    /**
     * Replaces underscores in snake case with spaces.
     *
     * @param string $name
     * @return string
     */
    protected function splitSnakes(string $name): string
    {
        return str_replace('_', ' ', $name);
    }

    /**
     * Splits camel-cased names while handling caps sections properly.
     *
     * @param string $name
     * @return string
     */
    protected function splitCamels(string $name): string
    {
        return preg_replace('/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/', ' $1', $name);
    }

    /**
     * Colours the duration if the test took longer than 500ms.
     *
     * @param float $time
     * @return string
     */
    protected function formatTestDuration(float $time): string
    {
        $timeInMs = ceil($time * 1000);
        $this->maxDuration = max($timeInMs, $this->maxDuration);
        $durationLength = strlen($this->maxDuration);
        $testDurationInMs = sprintf("%{$durationLength}d", $timeInMs);
        $duration = $timeInMs > 500 ? $this->formatWithColor('fg-yellow', $testDurationInMs) : $testDurationInMs;
        return sprintf('< %s ms', $duration);
    }

    /**
     * Colours the assertion count if it is 0
     *
     * @param int $count
     * @return string
     */
    protected function formatAssertionCount(int $count): string
    {
        $text = $count . ' assertions';
        if ($count <= 0) {
            $text = $this->formatWithColor('fg-red', $text);
        }
        return $text;
    }
}
