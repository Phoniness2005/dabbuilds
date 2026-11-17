#!/usr/bin/env bash
# List remote paths on Elementor Cloud SFTP.
# Usage: ./scripts/sftp-ls.sh [remote-path]
# Default path: $SFTP_REMOTE_ROOT/wp-content
set -euo pipefail
# shellcheck source=lib-env.sh
source "$(cd "$(dirname "$0")" && pwd)/lib-env.sh"

REMOTE_PATH="${1:-${SFTP_REMOTE_ROOT}/wp-content}"
# strip leading ./
REMOTE_PATH="${REMOTE_PATH#./}"
[[ -n "${REMOTE_PATH}" ]] || { echo "Remote path required" >&2; exit 1; }
[[ "${#REMOTE_PATH}" -le 512 ]] || { echo "Remote path too long" >&2; exit 1; }

echo "Listing: ${REMOTE_PATH}"
exec expect "$(dirname "$0")/sftp-cmd.exp" \
  "${SFTP_HOST}" "${SFTP_PORT}" "${SFTP_USER}" "${SFTP_PASSWORD}" \
  "ls -la ${REMOTE_PATH}"
