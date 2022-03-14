# PhpUnitPrinter

This library holds different printers for phpunit.

ok ok - at the moment there is only one: `TextPrinter`

# How to install

Use composer:

```console
$ composer require tflori/phpunit-printer
```

> note that there is no version defined - composer will automatically install the correct version for your
> php and phpunit version

## Using different phpunit versions in CI

You are maybe developing a library. Then you should not commit the `composer.lock` and you are probably
executing your unit tests on different php and phpunit versions. You will then need to modify your
`composer.json` manually to use any matching version of phpunit and phpunit-printer:

```json
{
  "require": {
    "phpunit/phpunit": "*",
    "tflori/phpunit-printer": "*"
  }
}
```

# How to use

You can now start using it by passing the printer to the phpunit configuration.

Via commandline:
```console
$ phpunit --printer PhpUnitPrinter\TextPrinter
```

Via configuration file:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         printerClass="PhpUnitPrinter\TextPrinter">
    <!-- ... -->
</phpunit>
```

## Available printer

### TextPrinter

The text printer is a copy of a script I found long time ago on the net. I don't remember where I found
it, and it didn't have annotations.

> If someone knows who has written that printer I would appreciate a hint to honor him in the author
> section.

Example:
```console
$ phpunit --color=always
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.


[35mSome\Name\CalculatorTest[0m
  [32m✔[0m ( 1 of 11; < 2 ms) [37mReturns The Sum with data set "1+2+3"[0m
  [32m✔[0m ( 2 of 11; < 1 ms) [37mReturns The Sum with data set "anything"[0m
  [32m✔[0m ( 3 of 11; < 1 ms) [37mReturns The Sum with data set "named"[0m
  [32m✔[0m ( 4 of 11; < 1 ms) [37mReturns The Power with data set #0[0m
  [32m✔[0m ( 5 of 11; < 1 ms) [37mReturns The Power with data set #1[0m

[35mSome\Name\StatusTest[0m
  [32m✔[0m ( 6 of 11; < 1 ms) [37mSuccessful Tests Show Green Checkmark[0m
  [31m✖[0m ( 7 of 11; < 1 ms) [31mFailing Tests Show Red Times Sign[0m
  [36mS[0m ( 8 of 11; < 1 ms) [36mSkipped Tests Show Cyan S[0m
  [33mI[0m ( 9 of 11; < 1 ms) [33mIncomplete Tests Show Yellow I[0m
  [33mR[0m (10 of 11; < 1 ms) [33mTests Without Assertions Show Yellow R[0m
  [31m![0m (11 of 11; < 1 ms) [31mTests With Errors Show Red Exclamation Mark[0m


Time: 17 ms, Memory: 4.00 MB
...
[37;41mERRORS![0m
[37;41mTests: 11[0m[37;41m, Assertions: 7[0m[37;41m, Errors: 1[0m[37;41m, Failures: 1[0m[37;41m, Skipped: 1[0m[37;41m, Incomplete: 1[0m[37;41m, Risky: 1[0m[37;41m.[0m
```
