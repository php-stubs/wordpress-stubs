<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function add_menu_page;
use function add_submenu_page;
use function add_links_page;
use function add_media_page;
use function add_pages_page;
use function add_posts_page;
use function add_theme_page;
use function add_users_page;
use function add_options_page;
use function add_plugins_page;
use function add_comments_page;
use function add_dashboard_page;
use function add_management_page;

add_menu_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_menu_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_menu_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_submenu_page('parent_slug', 'page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_submenu_page('parent_slug', 'page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_submenu_page('parent_slug', 'page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_links_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_links_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_links_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_media_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_media_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_media_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_pages_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_pages_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_pages_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_posts_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_posts_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_posts_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_theme_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_theme_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_theme_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_users_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_users_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_users_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_options_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_options_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_options_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_plugins_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_plugins_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_plugins_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_comments_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_comments_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_comments_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_dashboard_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_dashboard_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_dashboard_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct

add_management_page('page title', 'menu title', 'manage_options', 'menu_slug', 'notACallable'); // incorrect
add_management_page('page title', 'menu title', 'manage_options', 'menu_slug', ''); // correct
add_management_page('page title', 'menu title', 'manage_options', 'menu_slug', Faker::callable()); // correct
