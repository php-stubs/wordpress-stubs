<?php

declare(strict_types=1);

// phpcs:disable Squiz.PHP.CommentedOutCode

return \StubsGenerator\Finder::create()
    ->in('source/wordpress')
    // Shim for load-styles.php and load-scripts.php.
    ->notPath('wp-admin/includes/noop.php')
    // This file is not included by WordPress.
    ->notPath('wp-admin/install-helper.php')
    // Plugins and themes.
    ->notPath('wp-content')
    // Missing theme files.
    ->notPath('wp-includes/theme-compat')
    // Backward compatibility files.
    // $ find -iname "*compat*"
    ->notPath('wp-includes/compat.php')
    ->notPath('wp-includes/spl-autoload-compat.php')
    ->notPath('wp-includes/random_compat')
    ->notPath('wp-includes/sodium_compat')
    ->notPath('wp-includes/cache-compat.php')
    ->notPath('wp-includes/php-compat')
    // $ grep -rl '^_deprecated_file('
    ->notPath('wp-admin/admin-functions.php')
    ->notPath('wp-admin/custom-background.php')
    ->notPath('wp-admin/custom-header.php')
    ->notPath('wp-admin/includes/class-wp-upgrader-skins.php')
    ->notPath('wp-admin/upgrade-functions.php')
    ->notPath('wp-includes/class-feed.php')
    ->notPath('wp-includes/class-json.php')
    ->notPath('wp-includes/class-oembed.php')
    ->notPath('wp-includes/class-snoopy.php')
    ->notPath('wp-includes/date.php')
    ->notPath('wp-includes/embed-template.php')
    ->notPath('wp-includes/locale.php')
    ->notPath('wp-includes/registration-functions.php')
    ->notPath('wp-includes/registration.php')
    ->notPath('wp-includes/rss-functions.php')
    ->notPath('wp-includes/rss.php')
    ->notPath('wp-includes/session.php')
    //->notPath('wp-includes/spl-autoload-compat.php')
    //->notPath('wp-includes/theme-compat/comments.php')
    //->notPath('wp-includes/theme-compat/footer.php')
    //->notPath('wp-includes/theme-compat/header.php')
    //->notPath('wp-includes/theme-compat/sidebar.php')
/*
    ->notPath('wp-includes/SimplePie')
    ->notPath('wp-includes/class-simplepie.php')
    ->notPath('wp-includes/class-wp-feed-cache.php')
    ->notPath('wp-includes/class-wp-simplepie-file.php')
    ->notPath('wp-includes/class-wp-simplepie-sanitize-kses.php')
*/
    ->sortByName();
