# Developing

## Get the source

    $ git clone https://github.com/codeclimate/php-test-reporter

## Install dependencies

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar update -o -v

## Run the tests

    $ ./vendor/bin/phpunit
    
### With HTML coverage output:

	$ ./vendor/bin/phpunit --coverage-html=build/logs/coverage

## Build the PHAR tool

	# Create a new git tag (optional)
	$ git tag v1.x.x -m 'Version 1.x.x'
	# Build the PHAR using box project
	$ ./vendor/bin/box build

## Distribute the PHAR tool

### With verification and compatibility for phar.io / PhiVE

* [Create a GPG key](https://phar.io/howto/generate-gpg-key.html) (Should be the repositoy's maintainer one)
* [Create a signature and upload to Github](https://phar.io/howto/sign-and-upload-to-github.html)

### Without verification

* Go to the [releases section on Github](https://github.com/codeclimate/php-test-reporter/releases)
* Click "Edit" on the latest tag/release
* Add the `codeclimate-test-reporter.phar` in the "Attach binaries..." section
* Click "Update release"

## Contribute 

* Submit PRs to: https://github.com/codeclimate/php-test-reporter
* *Note*: all changes and fixes must have appropriate test coverage.
