#!/usr/bin/env bash
# List remote paths on Elementor Cloud SFTP.
# Usage: ./scripts/sftp-ls.sh [remote-path]
# Default path: $SFTP_REMOTE_ROOT/wp-content
set -euo pipefail
source "$(cd "$(dirname "$0")" && pwd)/lib-env.sh"

REMOTE_PATH="${1:-${SFTP_REMOTE_ROOT}/wp-content}"
# strip leading ./ 
REMOTE_PATH="${REMOTE_PATH#./}"

echo "Listing: ${REMOTE_PATH}"
exec expect "$(dirname "$0")/sftp-cmd.exp" \
  "${SFTP_HOST}" "${SFTP_PORT}" "${SFTP_USER}" "${SFTP_PASSWORD}" \
  "ls -la ${REMOTE_PATH}"
