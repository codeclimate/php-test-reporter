# CONTRIBUTING

We're using [Travis CI](https://travis-ci.com) as a continuous integration system.
 
For details, see [`.travis.yml`](../.travis.yml). 
 
## Tests

We're using [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) to drive the development.

Run

```
$ composer test
```

to run all the tests.

## Coding Standards

We are using [`friendsofphp/php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer) to enforce coding standards.

Run

```
$ composer cs
```

to automatically fix coding standard violations.
