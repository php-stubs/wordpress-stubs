#!/usr/bin/env bash

set -e

CORE_JSON="$(wget -q -O- "https://packagist.org/packages/johnpbloch/wordpress-core.json")"

for V in 4.7  4.8  4.9  5.0  5.1  5.2  5.3; do
    # Find latest version
    printf -v JQ_QUERY '.package.versions[].version | select(test("^%s\\\\.%s\\\\.\\\\d+$"))' "${V%.*}" "${V#*.}"
    LATEST="$(jq -r "$JQ_QUERY" <<<"$CORE_JSON" | sort -t "." -k 3 -g | tail -n 1)"
    if [ -z "$LATEST" ]; then
        echo "No version for ${V}!"
        continue;
    fi

    echo "Releasing ${LATEST} version ..."

    if git rev-parse "refs/tags/v${LATEST}" >/dev/null 2>&1; then
        echo "Tag exists!"
        continue;
    fi

    # Modify composer.json
    printf -v SED_EXP 's#\\("johnpbloch/wordpress"\\): "[0-9]\\+\\.[0-9]\\+\\.[0-9]\\+"#\\1: "%s"#' "$LATEST"
    sed -e "$SED_EXP" -i composer.json

    # Generate stubs
    composer update --no-interaction --no-suggest
    echo "Generating stubs ..."
    ./generate.sh

    # Tag version
    git commit --all -m "Generate stubs for WordPress ${LATEST}"
    git tag "v${LATEST}"
done
