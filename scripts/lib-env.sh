#!/usr/bin/env bash
# Load .env.local from repo root. Never print secrets.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_FILE="${ROOT}/.env.local"

if [[ ! -f "${ENV_FILE}" ]]; then
  echo "Missing ${ENV_FILE}" >&2
  echo "Copy .env.example to .env.local and add your SFTP credentials." >&2
  exit 1
fi

set -a
# shellcheck disable=SC1090
source "${ENV_FILE}"
set +a

[[ -n "${SFTP_HOST:-}" ]] || { echo "SFTP_HOST required in .env.local" >&2; exit 1; }
[[ -n "${SFTP_PORT:-}" ]] || { echo "SFTP_PORT required in .env.local" >&2; exit 1; }
[[ -n "${SFTP_USER:-}" ]] || { echo "SFTP_USER required in .env.local" >&2; exit 1; }
[[ -n "${SFTP_PASSWORD:-}" ]] || { echo "SFTP_PASSWORD required in .env.local" >&2; exit 1; }
if [[ -z "${SFTP_REMOTE_ROOT:-}" ]]; then
  SFTP_REMOTE_ROOT="/html"
fi
[[ -n "${SFTP_REMOTE_ROOT}" ]] || { echo "SFTP_REMOTE_ROOT required in .env.local" >&2; exit 1; }

export ROOT ENV_FILE SFTP_HOST SFTP_PORT SFTP_USER SFTP_PASSWORD SFTP_REMOTE_ROOT
