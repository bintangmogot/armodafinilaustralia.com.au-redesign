#!/usr/bin/env bash
set -euo pipefail
command -v php >/dev/null
command -v node >/dev/null
npm ci --no-audit --no-fund
npm run build
find . -name '*.php' -not -path './node_modules/*' -print0 | xargs -0 -n1 php -l
