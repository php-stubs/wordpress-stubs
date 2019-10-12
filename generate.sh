#!/usr/bin/env bash

HEADER=$'/**\n * Generated stub declarations for WordPress.\n * @see https://wordpress.org\n * @see https://github.com/szepeviktor/wordpress-stubs\n */'

FILE="wordpress-stubs.php"

# Exclude globals.
"$(dirname "$0")/vendor/bin/generate-stubs" \
    --force \
    --finder=finder.php \
    --out="$FILE" \
    --header="$HEADER" \
    --functions \
    --classes \
    --interfaces \
    --traits

# Shim the global $wpdb declaration, since it's actually set up inside a
# function call.
printf '\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = \\null;\n' >>$FILE

# Trim tailing whitespaces. Not using sed command because it seemed to struggle with
# some characters in the file.
perl -i -lpe 's/[[:space:]]+$//g' "$FILE"
