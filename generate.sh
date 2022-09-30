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

## Use literal-string type for wpdb::prepare() query statement parameter.
#sed -i -e 's#^.*@param string \+\$query \+Query statement.*$#&\n         * @phpstan-param literal-string $query#' "$FILE"

# Shim the global $wpdb declaration, since it's actually set up inside a function call.
if grep -qFx 'namespace {' "$FILE"; then
    printf '\nnamespace {\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = \\null;\n}\n' >>"$FILE"
else
    printf '\n/**\n * WordPress database abstraction object.\n * @var wpdb\n */\n$wpdb = \\null;\n' >>"$FILE"
fi

# These are function that need a extra attribute to prevent php8+ notices.
declare -a PHP_FUNCTIONS=(
    'Requests_Utility_FilteredIterator::unserialize'
    'Requests_Utility_FilteredIterator::__unserialize'
    'Requests_Utility_FilteredIterator::current'
    'Requests_Cookie_Jar::offsetExists'
    'Requests_Cookie_Jar::offsetGet'
    'Requests_Cookie_Jar::offsetSet'
    'Requests_Cookie_Jar::offsetUnset'
    'Requests_Cookie_Jar::getIterator'
    'Requests_Utility_CaseInsensitiveDictionary::offsetExists'
    'Requests_Utility_CaseInsensitiveDictionary::offsetGet'
    'Requests_Utility_CaseInsensitiveDictionary::offsetSet'
    'Requests_Utility_CaseInsensitiveDictionary::offsetUnset'
    'Requests_Utility_CaseInsensitiveDictionary::getIterator'
)
for PHP_FUNCTION in "${PHP_FUNCTIONS[@]}"; do
    # Get the line where the method is defined.
    LINE=$(php -r "include 'wordpress-stubs.php'; print (new ReflectionMethod('${PHP_FUNCTION}'))->getStartLine();")
    echo "${PHP_FUNCTION} is defined on line ${LINE}"

    # Check the line above for #[ReturnTypeWillChange]
    if [[ $(sed "$((${LINE}-1))q;d" ${FILE}) == *'#[ReturnTypeWillChange]' ]]; then
        echo "${PHP_FUNCTION} already has #[ReturnTypeWillChange]"
        continue # Already there.
    fi

    # Grab the current leading whitespace so we can keep the #[ReturnTypeWillChange] indented correctly.
    LEADING_WHITESPACE="$(sed "${LINE}q;d" ${FILE} | sed "s#\([[:space:]]\+\)\(.*\)#\1#")"
    # Insert the #[ReturnTypeWillChange]
    sed -e "${LINE}i\\" -e "${LEADING_WHITESPACE}#[ReturnTypeWillChange]" -i ${FILE}
done
