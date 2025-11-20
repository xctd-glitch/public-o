#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOG_DIR="$ROOT_DIR/logs"
CACHE_DIR="$ROOT_DIR/tmp"
ASSETS_DIST="$ROOT_DIR/public_html/assets/dist"

mkdir -p "$LOG_DIR"
mkdir -p "$CACHE_DIR"

printf "[clean] Clearing generated logs and cache...\n"
if find "$LOG_DIR" -mindepth 1 -maxdepth 1 -print -quit | grep -q .; then
    find "$LOG_DIR" -mindepth 1 -maxdepth 1 -print -exec rm -rf {} +
fi

if find "$CACHE_DIR" -mindepth 1 -maxdepth 1 -print -quit | grep -q .; then
    find "$CACHE_DIR" -mindepth 1 -maxdepth 1 -print -exec rm -rf {} +
fi

if [ -d "$ASSETS_DIST" ]; then
    printf "[clean] Removing built assets at %s\n" "$ASSETS_DIST"
    rm -rf "$ASSETS_DIST"
fi

printf "[clean] Done.\n"
