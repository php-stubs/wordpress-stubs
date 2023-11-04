<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

class Finder extends \StubsGenerator\Finder
{
    public function __construct()
    {
        parent::__construct();
        $this->prepareFinder();
    }

    private function prepareFinder(): void
    {
        $this
            ->sortByName();

        $this->excludeCommonPaths();
        $this->excludeBackwardCompatibilityFiles();
        $this->excludeDeprecatedFiles();
    }

    private function excludeCommonPaths(): void
    {
        $this
            // Shim for load-styles.php and load-scripts.php.
            ->notPath('wp-admin/includes/noop.php')
            // This file is not included by WordPress.
            ->notPath('wp-admin/install-helper.php')
            // Plugins and themes.
            ->notPath('wp-content')
            // Missing theme files.
            ->notPath('wp-includes/theme-compat');
    }

    /**
     * $ find -iname "*compat*"
     */
    private function excludeBackwardCompatibilityFiles(): void
    {
        $this
            ->notPath('wp-includes/cache-compat.php')
            ->notPath('wp-includes/compat.php')
            ->notPath('wp-includes/php-compat')
            ->notPath('wp-includes/random_compat')
            ->notPath('wp-includes/sodium_compat')
            ->notPath('wp-includes/spl-autoload-compat.php');
            // Excluded via excludeCommonPaths():
            //->notPath('wp-includes/theme-compat/comments.php')
            //->notPath('wp-includes/theme-compat/footer.php')
            //->notPath('wp-includes/theme-compat/header.php')
            //->notPath('wp-includes/theme-compat/sidebar.php');
    }

    /**
     * $ grep -rl '^_deprecated_file('
     */
    private function excludeDeprecatedFiles(): void
    {
        $this
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
            ->notPath('wp-includes/session.php');
    }
}
