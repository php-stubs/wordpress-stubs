#!/usr/bin/env bash

HEADER=$'/**\n * Generated stub declarations for WordPress.\n * https://wordpress.org\n * https://github.com/GiacoCorsiglia/wordpress-stubs\n */\n/** @var wpdb */\n$wpdb = new wpdb("","","","");\n'

"$(dirname $0)/vendor/bin/generate-stubs" --finder=finder.php --out=wordpress-stubs.php --force --header="$HEADER"
