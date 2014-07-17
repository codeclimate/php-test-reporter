[![Code Climate](https://codeclimate.com/github/codeclimate/php-test-reporter.png)](https://codeclimate.com/github/codeclimate/php-test-reporter) [![Build Status](https://travis-ci.org/codeclimate/php-test-reporter.svg?branch=master)](https://travis-ci.org/codeclimate/php-test-reporter)

# codeclimate-test-reporter

Collects test coverage data from your PHP test suite and sends it to 
Code Climate's hosted, automated code review service.

Code Climate - https://codeclimate.com

**Important:** If you encounter an error involving SSL certificates, see the **Known Issue: SSL Certificate Error** section below.

## Installation

This package requires a user, but not necessarily a paid account, on 
Code Climate, so if you don't have one the first step is to signup at: 
https://codeclimate.com.

To install php-test-reporter with Composer first add the following to 
your composer.json file:

**composer.json**

```javascript
{
  "require-dev": {
    "codeclimate/php-test-reporter": "dev-master"
  }
}
```

Then, run:

```
$ php composer.phar install --dev
```

If adding the test-reporter to an existing project, run:

```
$ php composer.phar update codeclimate/php-test-reporter --dev
```

## Usage

- Generate coverage data to `build/logs/clover.xml`

Add the following to phpunit.dist.xml:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit ...>
  <logging>
    ...
    <log type="coverage-clover" target="build/logs/clover.xml"/>
    ...
  </logging>
</phpunit>
```

Or invoke `phpunit` as follows:

```
$ phpunit --coverage-clover build/logs/clover.xml
```

- Specifying your repo token as an environment variable, invoke the 
  test-reporter:

```
$ CODECLIMATE_REPO_TOKEN="..." vendor/bin/test-reporter
```

The `CODECLIMATE_REPO_TOKEN` value is provided after you add your repo 
to your Code Climate account by clicking on "Setup Test Coverage" on the 
right hand side of your feed.

Please contact hello@codeclimate.com if you need any assistance setting 
this up.

## Known Issue: SSL Certificate Error

If you encounter an error involving SSL certificates when trying to report
coverage data from your CI server, you can work around it by manually posting
the data via `curl`:

```yaml
after_script:
  - CODECLIMATE_REPO_TOKEN="..." bin/test-reporter --stdout > codeclimate.json
  - curl -X POST -d @codeclimate.json -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.1)' https://codeclimate.com/test_reports
```

More details can be found in [this issue][issue].

[issue]: https://github.com/codeclimate/php-test-reporter/issues/3


## Contributions

Patches, bug fixes, feature requests, and pull requests are welcome on 
the GitHub page for this project:

https://github.com/codeclimate/php-test-reporter

This package is maintained by Bryan Helmkamp (bryan@codeclimate.com).

## Copyright

See LICENSE.txt

Portions of the implementation were inspired by the php-coveralls 
project.

