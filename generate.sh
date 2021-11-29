#!/usr/bin/env bash

HEADER=$'/**\n * Generated stub declarations for WordPress.\n * @see https://wordpress.org\n * @see https://github.com/php-stubs/wordpress-stubs\n */'

FILE="wordpress-stubs.php"

set -e

test -f "$FILE"
test -d "source/wordpress"

# Download dependencies
if [ ! -d vendor ]; then
    composer update
fi

# Exclude globals.
"$(dirname "$0")/vendor/bin/generate-stubs" \
    --force \
    --finder=finder.php \
    --visitor=visitor.php \
    --header="$HEADER" \
    --functions \
    --classes \
    --interfaces \
    --traits \
    --out="$FILE"

# Shim the global $wpdb declaration, since it's actually set up inside a function call.
if grep -qFx 'namespace {' "$FILE"; then
    printf '\nnamespace {\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = \\null;\n}\n' >>"$FILE"
else
    printf '\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = \\null;\n' >>"$FILE"
fi
