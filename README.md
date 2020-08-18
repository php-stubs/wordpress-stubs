# WordPress Stubs

[![Build Status](https://travis-ci.com/php-stubs/wordpress-stubs.svg?branch=master)](https://travis-ci.com/php-stubs/wordpress-stubs)

This package is a fork of `giacocorsiglia/wordpress-stubs`.
It provides stub declarations for [WordPress](https://wordpress.org/)
core functions, classes and interfaces, **globals are not included**.
These stubs can help plugin and theme developers leverage static analysis tools
like [PHPStan](https://github.com/phpstan/phpstan),
which is not able to parse WordPress as it is not OOP code.

The stubs are generated directly from the [source](https://github.com/johnpbloch/wordpress-core)
using [giacocorsiglia/stubs-generator](https://github.com/GiacoCorsiglia/php-stubs-generator).

### Requirements

- PHP >=7.1
- Sodium PHP extension as latest WordPress core uses it and **compat code is removed** from stubs,
  Sodium is included in PHP from version 7.2, in 7.1 issue `pecl install libsodium`
  or install the `paragonie/sodium_compat` package
- For PHP <7.3 install the `symfony/polyfill-php73` as development dependency

### Installation

Require this package as a development dependency with [Composer](https://getcomposer.org).

```bash
composer require --dev php-stubs/wordpress-stubs
```

Alternatively you may download `wordpress-stubs.php` directly.

### Usage with PHPStan

```bash
composer require --dev szepeviktor/phpstan-wordpress
```

The package [`szepeviktor/phpstan-wordpress`](https://github.com/szepeviktor/phpstan-wordpress)
depends on [`phpstan/phpstan`](http://github.com/phpstan/phpstan) and this one.
Please do read
[that package's README](https://github.com/szepeviktor/phpstan-wordpress/blob/master/README.md)
and see the `example` directory over there.

### Usage with Psalm

Update your Psalm config to include this section.

```xml
<stubs>
    <file name="vendor/php-stubs/wordpress-stubs/wordpress-stubs.php" />
</stubs>
```

Furthermore ensure WordPress core is _not_ included in `<projectFiles>`.

### Usage in Intellisense

If your IDE has trouble parsing all of WordPress
you may find the stubs useful for enabling code completion and related features.
For example there are [instructions](https://github.com/bmewburn/vscode-intelephense/issues/113)
for usage with VSCode's
[Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
extension.

### Versioning

This package is versioned to match the WordPress version from which the stubs are generated.

### Generating stubs for a different WordPress version

1. Run modern PHP version
1. Clone this repository and `cd` into it
1. Update `"johnpbloch/wordpress": "x.x.x"` in `composer.json` with the desired version
1. Run `composer update`
1. And run `./generate.sh`

The `wordpress-stubs.php` file should now be updated.
