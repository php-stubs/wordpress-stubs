#!/usr/bin/env bash

# @TODO See https://github.com/johnpbloch/build-wp/blob/master/files/run.sh

set -e

CORE_JSON="$(wget -q -O- "https://packagist.org/packages/johnpbloch/wordpress-core.json")"

# @TODO Use branches!
for V in                             4.7  4.8  4.9 \
         5.0 5.1 5.2 5.3 5.4 5.5 5.6; do
    # Find latest version
    printf -v JQ_FILTER '.package.versions[].version | select(test("^%s\\\\.%s\\\\.\\\\d+$"))' "${V%.*}" "${V#*.}"
    LATEST="$(jq -r "$JQ_FILTER" <<<"$CORE_JSON" | sort -t "." -k 3 -g | tail -n 1)"
    if [ -z "$LATEST" ]; then
        echo "No version for ${V}!"
        continue;
    fi

    echo "Releasing ${LATEST} version ..."

    if git rev-parse "refs/tags/v${LATEST}" >/dev/null 2>&1; then
        echo "Tag exists!"
        continue;
    fi

    # Get new version
    printf -v SED_EXP 's#\\("johnpbloch/wordpress"\\): "[0-9]\\+\\.[0-9]\\+\\.[0-9]\\+"#\\1: "%s"#' "$LATEST"
    sed -i -e "$SED_EXP" source/composer.json
    composer run-script post-install-cmd

    # Generate stubs
    echo "Generating stubs ..."
    ./generate.sh

    # Tag version
    git commit --all -m "Generate stubs for WordPress ${LATEST}"
    git tag "v${LATEST}"
done
