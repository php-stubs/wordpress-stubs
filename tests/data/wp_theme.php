<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Theme;

use function PHPStan\Testing\assertType;

$type = new TypeHelper();
$wpTheme = new WP_Theme($type->string, $type->string);

// WP_Theme::get()
assertType('string', $wpTheme->get('Name'));
assertType('string', $wpTheme->get('ThemeURI'));
assertType('string', $wpTheme->get('Description'));
assertType('string', $wpTheme->get('Author'));
assertType('string', $wpTheme->get('AuthorURI'));
assertType('string', $wpTheme->get('Version'));
assertType('string', $wpTheme->get('Template'));
assertType('string', $wpTheme->get('Status'));
assertType('array<string>', $wpTheme->get('Tags'));
assertType('string', $wpTheme->get('TextDomain'));
assertType('string', $wpTheme->get('DomainPath'));
assertType('string', $wpTheme->get('RequiresWP'));
assertType('string', $wpTheme->get('RequiresPHP'));
assertType('string', $wpTheme->get('UpdateURI'));
assertType('false', $wpTheme->get('NoThemeHeader'));
assertType('array<string>|string|false', $wpTheme->get($type->string));

// WP_Theme::offsetExists()
assertType('false', $wpTheme->offsetExists('NoThemeKey'));
assertType('true', $wpTheme->offsetExists('Name'));
assertType('true', $wpTheme->offsetExists('Version'));
assertType('true', $wpTheme->offsetExists('Status'));
assertType('true', $wpTheme->offsetExists('Title'));
assertType('true', $wpTheme->offsetExists('Author'));
assertType('true', $wpTheme->offsetExists('Author Name'));
assertType('true', $wpTheme->offsetExists('Author URI'));
assertType('true', $wpTheme->offsetExists('Description'));
assertType('true', $wpTheme->offsetExists('Template'));
assertType('true', $wpTheme->offsetExists('Stylesheet'));
assertType('true', $wpTheme->offsetExists('Template Files'));
assertType('true', $wpTheme->offsetExists('Stylesheet Files'));
assertType('true', $wpTheme->offsetExists('Template Dir'));
assertType('true', $wpTheme->offsetExists('Stylesheet Dir'));
assertType('true', $wpTheme->offsetExists('Screenshot'));
assertType('true', $wpTheme->offsetExists('Tags'));
assertType('true', $wpTheme->offsetExists('Theme Root'));
assertType('true', $wpTheme->offsetExists('Theme Root URI'));
assertType('true', $wpTheme->offsetExists('Parent Theme'));
assertType('bool', $wpTheme->offsetExists($type->string));

// WP_Theme::offsetGet()
assertType('null', $wpTheme->offsetGet('NoThemeKey'));
assertType('mixed', $wpTheme->offsetGet('Name'));
assertType('mixed', $wpTheme->offsetGet('Version'));
assertType('mixed', $wpTheme->offsetGet('Status'));
assertType('mixed', $wpTheme->offsetGet('Title'));
assertType('mixed', $wpTheme->offsetGet('Author'));
assertType('mixed', $wpTheme->offsetGet('Author Name'));
assertType('mixed', $wpTheme->offsetGet('Author URI'));
assertType('mixed', $wpTheme->offsetGet('Description'));
assertType('mixed', $wpTheme->offsetGet('Template'));
assertType('mixed', $wpTheme->offsetGet('Stylesheet'));
assertType('mixed', $wpTheme->offsetGet('Template Files'));
assertType('mixed', $wpTheme->offsetGet('Stylesheet Files'));
assertType('mixed', $wpTheme->offsetGet('Template Dir'));
assertType('mixed', $wpTheme->offsetGet('Stylesheet Dir'));
assertType('mixed', $wpTheme->offsetGet('Screenshot'));
assertType('mixed', $wpTheme->offsetGet('Tags'));
assertType('mixed', $wpTheme->offsetGet('Theme Root'));
assertType('mixed', $wpTheme->offsetGet('Theme Root URI'));
assertType('mixed', $wpTheme->offsetGet('Parent Theme'));
assertType('mixed', $wpTheme->offsetGet($type->string));
