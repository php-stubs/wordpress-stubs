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

if [ -r source/wordpress/wp-includes/Requests/Cookie/Jar.php ]; then
    # Add ReturnTypeWillChange attribute to PHP 8-incompatible methods.
    declare -r -a REQUESTS_V1_METHODS=(
        "Requests_Cookie_Jar::getIterator"
        "Requests_Cookie_Jar::offsetExists"
        "Requests_Cookie_Jar::offsetGet"
        "Requests_Cookie_Jar::offsetSet"
        "Requests_Cookie_Jar::offsetUnset"
        "Requests_Utility_CaseInsensitiveDictionary::getIterator"
        "Requests_Utility_CaseInsensitiveDictionary::offsetExists"
        "Requests_Utility_CaseInsensitiveDictionary::offsetGet"
        "Requests_Utility_CaseInsensitiveDictionary::offsetSet"
        "Requests_Utility_CaseInsensitiveDictionary::offsetUnset"
        "Requests_Utility_FilteredIterator::current"
        "Requests_Utility_FilteredIterator::__unserialize"
        "Requests_Utility_FilteredIterator::unserialize"
    )
    for METHOD in "${REQUESTS_V1_METHODS[@]}"; do
        # Get the line number where the method is defined.
        LINE="$(php -r "require 'wordpress-stubs.php'; print (new ReflectionMethod('${METHOD}'))->getStartLine();")"
        if [ -z "${LINE}" ]; then
            continue
        fi
        echo "${METHOD} is defined on line ${LINE}."

        # Check the previous line for ReturnTypeWillChange attribute.
        if sed -e "$((LINE - 1)) !d" "${FILE}" | grep -q -F '#[ReturnTypeWillChange]'; then
            continue
        fi

        # Grab leading whitespace on the current line so we can indent ReturnTypeWillChange correctly.
        LEADING_WHITESPACES="$(sed -e "${LINE} !d;s#^\\(\\s\\+\\).*\$#\\1#" "${FILE}")"
        # Insert the ReturnTypeWillChange attribute.
        sed -i -e "${LINE} i\\" -e "${LEADING_WHITESPACES}#[ReturnTypeWillChange]" "${FILE}"
    done
fi
