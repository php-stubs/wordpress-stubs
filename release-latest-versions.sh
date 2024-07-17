#!/usr/bin/env bash

# @TODO See https://github.com/johnpbloch/build-wp/blob/master/files/run.sh

set -e

Do_release()
{
    local VERSION="$1"
    local SED_EXP

    echo "Releasing ${VERSION} version ..."

    if git rev-parse "refs/tags/v${VERSION}" >/dev/null 2>&1; then
        echo "Tag exists!"
        echo
        return 0
    fi

    # Get new version
    printf -v SED_EXP 's#\\("johnpbloch/wordpress"\\): "[0-9]\\+\\.[0-9]\\+\\.[0-9]\\+"#\\1: "%s"#' "${VERSION}"
    sed -i -e "$SED_EXP" source/composer.json
    composer run-script post-install-cmd

    # Generate stubs
    echo "Generating stubs ..."
    ./generate.sh

    # Tag version
    git commit --all -m "Generate stubs for WordPress ${VERSION}"
    git tag "v${VERSION}"
}

CORE_JSON="$(wget -q -O- "https://packagist.org/packages/johnpbloch/wordpress-core.json")"

# @TODO Use branches!
#for MINOR in                        4.7 4.8 4.9 \
#        5.0 5.1 5.2 5.3 5.4 5.5 5.6 5.7 5.8 5.9 \
for MINOR in \
        6.0 6.1 6.2 6.3 6.4 6.5 6.6 6.7; do
    # Find latest version
    printf -v JQ_FILTER '.package.versions[].version | select(test("^%s\\\\.%s\\\\.\\\\d+$"))' "${MINOR%.*}" "${MINOR#*.}"
    LATEST_FIVE="$(jq -r "$JQ_FILTER" <<<"$CORE_JSON" | sort -t "." -k 3 -g | tail -n 5)"

    if [ -z "${LATEST_FIVE}" ]; then
        echo "No version for ${MINOR}!"
        echo
        continue
    fi

    while read -r PATCH; do
        Do_release "${PATCH}"
    done <<<"${LATEST_FIVE}"
done
