#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PHP_BIN=${PHP_BIN:-php}

printf "[build] Linting PHP sources with %s...\n" "$PHP_BIN"
mapfile -t PHP_FILES < <(find "$ROOT_DIR" -type f -name "*.php" \
    ! -path "*/vendor/*" \
    ! -path "*/node_modules/*" \
    ! -path "*/logs/*" \
    ! -path "*/tmp/*")

if [ ${#PHP_FILES[@]} -eq 0 ]; then
    printf "[build] No PHP files found to lint.\n"
else
    for file in "${PHP_FILES[@]}"; do
        "$PHP_BIN" -l "$file" >/dev/null
    done
fi

printf "[build] PHP lint completed.\n"

ASSETS_SRC_DIR="$ROOT_DIR/public_html/assets"
ASSETS_DIST="$ASSETS_SRC_DIR/dist"

mkdir -p "$ASSETS_DIST"
printf "[build] Preparing assets directory at %s\n" "$ASSETS_DIST"

if [ -f "$ASSETS_SRC_DIR/style.css" ]; then
    cp "$ASSETS_SRC_DIR/style.css" "$ASSETS_DIST/style.css"
    printf "[build] Copied style.css to dist/.\n"
fi

printf "[build] Done.\n"
