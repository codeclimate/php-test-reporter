# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com).

## [Unreleased](https://github.com/codeclimate/php-test-reporter/compare/v0.4.4...HEAD)

(add details here)

## [v0.4.4](https://github.com/codeclimate/php-test-reporter/compare/v0.4.3...v0.4.4)

### Fixed

- Format Gitlab CI payloads in the same way as we do in other test reporters ([#116](https://github.com/codeclimate/php-test-reporter/pull/116))

## [v0.4.3](https://github.com/codeclimate/php-test-reporter/compare/v0.4.2...v0.4.3)

### Added

- Added support for Gitlab CI ([#113](https://github.com/codeclimate/php-test-reporter/pull/113))

### Fixed

- Restore compatibility with PHP 5.3 ([@localheinz])

## [v0.4.2](https://github.com/codeclimate/php-test-reporter/compare/v0.4.1...v0.4.2)

### Fixed

- Fix bug in payload structure ([@localheinz])

## [v0.4.1](https://github.com/codeclimate/php-test-reporter/compare/v0.4.0...v0.4.1)

- Internal fixes to code, documentation, and packaging ([@localheinz])

## v0.4.0

### Added

- Executable .phar file for download
- `upload` command (PHAR only) - same as calling the tool without a command when installed via composer.
- `self-update` / `selfupdate` command (PHAR only)
- `rollback` command (PHAR only)
- [Installation / Usage](./README.md) / [Distribution instructions](./DEVELOPING.md) for the PHAR tool

[@localheinz]: https://github.com/localheinz
