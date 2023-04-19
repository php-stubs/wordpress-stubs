<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

/** @var \WP_Theme */
$theme = $theme;

// WP_Theme::get()
assertType('string', $theme->get('Name'));
assertType('string', $theme->get('ThemeURI'));
assertType('string', $theme->get('Description'));
assertType('string', $theme->get('Author'));
assertType('string', $theme->get('AuthorURI'));
assertType('string', $theme->get('Version'));
assertType('string', $theme->get('Template'));
assertType('string', $theme->get('Status'));
assertType('array<string>', $theme->get('Tags'));
assertType('string', $theme->get('TextDomain'));
assertType('string', $theme->get('DomainPath'));
assertType('string', $theme->get('RequiresWP'));
assertType('string', $theme->get('RequiresPHP'));
assertType('string', $theme->get('UpdateURI'));
assertType('false', $theme->get('NoThemeHeader'));
assertType('array<string>|string|false', $theme->get((string)$_GET['unknown_string']));

// WP_Theme::offsetExists()
assertType('false', $theme->offsetExists('NoThemeKey'));
assertType('true', $theme->offsetExists('Name'));
assertType('true', $theme->offsetExists('Version'));
assertType('true', $theme->offsetExists('Status'));
assertType('true', $theme->offsetExists('Title'));
assertType('true', $theme->offsetExists('Author'));
assertType('true', $theme->offsetExists('Author Name'));
assertType('true', $theme->offsetExists('Author URI'));
assertType('true', $theme->offsetExists('Description'));
assertType('true', $theme->offsetExists('Template'));
assertType('true', $theme->offsetExists('Stylesheet'));
assertType('true', $theme->offsetExists('Template Files'));
assertType('true', $theme->offsetExists('Stylesheet Files'));
assertType('true', $theme->offsetExists('Template Dir'));
assertType('true', $theme->offsetExists('Stylesheet Dir'));
assertType('true', $theme->offsetExists('Screenshot'));
assertType('true', $theme->offsetExists('Tags'));
assertType('true', $theme->offsetExists('Theme Root'));
assertType('true', $theme->offsetExists('Theme Root URI'));
assertType('true', $theme->offsetExists('Parent Theme'));
assertType('bool', $theme->offsetExists((string)$_GET['unknown_string']));

// WP_Theme::offsetGet()
assertType('null', $theme->offsetGet('NoThemeKey'));
assertType('mixed', $theme->offsetGet('Name'));
assertType('mixed', $theme->offsetGet('Version'));
assertType('mixed', $theme->offsetGet('Status'));
assertType('mixed', $theme->offsetGet('Title'));
assertType('mixed', $theme->offsetGet('Author'));
assertType('mixed', $theme->offsetGet('Author Name'));
assertType('mixed', $theme->offsetGet('Author URI'));
assertType('mixed', $theme->offsetGet('Description'));
assertType('mixed', $theme->offsetGet('Template'));
assertType('mixed', $theme->offsetGet('Stylesheet'));
assertType('mixed', $theme->offsetGet('Template Files'));
assertType('mixed', $theme->offsetGet('Stylesheet Files'));
assertType('mixed', $theme->offsetGet('Template Dir'));
assertType('mixed', $theme->offsetGet('Stylesheet Dir'));
assertType('mixed', $theme->offsetGet('Screenshot'));
assertType('mixed', $theme->offsetGet('Tags'));
assertType('mixed', $theme->offsetGet('Theme Root'));
assertType('mixed', $theme->offsetGet('Theme Root URI'));
assertType('mixed', $theme->offsetGet('Parent Theme'));
assertType('mixed', $theme->offsetGet((string)$_GET['unknown_string']));
