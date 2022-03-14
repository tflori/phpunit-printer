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
<pre>
$ phpunit --color=always
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.


<span style="color: mediumpurple">Some\Name\CalculatorTest</span>
  <span style="color: green">✔</span> ( 1 of 11; < 2 ms) <span style="color: grey">Returns The Sum with data set "1+2+3"</span>
  <span style="color: green">✔</span> ( 2 of 11; < 1 ms) <span style="color: grey">Returns The Sum with data set "anything"</span>
  <span style="color: green">✔</span> ( 3 of 11; < 1 ms) <span style="color: grey">Returns The Sum with data set "named"</span>
  <span style="color: green">✔</span> ( 4 of 11; < 1 ms) <span style="color: grey">Returns The Power with data set #0</span>
  <span style="color: green">✔</span> ( 5 of 11; < 1 ms) <span style="color: grey">Returns The Power with data set #1</span>

<span style="color: mediumpurple">Some\Name\StatusTest</span>
  <span style="color: green">✔</span> ( 6 of 11; < 1 ms) <span style="color: grey">Successful Tests Show Green Checkmark</span>
  <span style="color: red">✖</span> ( 7 of 11; < 1 ms) <span style="color: red">Failing Tests Show Red Times Sign</span>
  <span style="color: cyan">S</span> ( 8 of 11; < 1 ms) <span style="color: cyan">Skipped Tests Show Cyan S</span>
  <span style="color: yellow">I</span> ( 9 of 11; < 1 ms) <span style="color: yellow">Incomplete Tests Show Yellow I</span>
  <span style="color: yellow">R</span> (10 of 11; < 1 ms) <span style="color: yellow">Tests Without Assertions Show Yellow R</span>
  <span style="color: red">!</span> (11 of 11; < 1 ms) <span style="color: red">Tests With Errors Show Red Exclamation Mark</span>


Time: 17 ms, Memory: 4.00 MB
...
<span style="background: red">ERRORS!</span>
<span style="background: red">Tests: 11</span><span style="background: red">, Assertions: 7</span><span style="background: red">, Errors: 1</span><span style="background: red">, Failures: 1</span><span style="background: red">, Skipped: 1</span><span style="background: red">, Incomplete: 1</span><span style="background: red">, Risky: 1</span><span style="background: red">.</span>
</pre>
