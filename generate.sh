#!/usr/bin/env bash

HEADER=$'/**\n * Generated stub declarations for WordPress.\n * https://wordpress.org\n * https://github.com/GiacoCorsiglia/wordpress-stubs\n */'

FILE="wordpress-stubs.php"

"$(dirname $0)/vendor/bin/generate-stubs" \
  --finder=finder.php \
  --out="$FILE" \
  --force \
  --header="$HEADER" \
  --nullify-globals

# Shim the global $wpdb declaration, since it's actually set up inside a
# function call.
echo $'\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = null;' >> $FILE

# Trim tailing whitespace.  Not using sed because it seemed to struggle with
# some characters in the file.
perl -i -lpe "s/[[:space:]]+$//g" $FILE
