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

# shellcheck disable=SC1090
set -a
source "${ENV_FILE}"
set +a

: "${SFTP_HOST:?SFTP_HOST required in .env.local}"
: "${SFTP_PORT:?SFTP_PORT required in .env.local}"
: "${SFTP_USER:?SFTP_USER required in .env.local}"
: "${SFTP_PASSWORD:?SFTP_PASSWORD required in .env.local}"
: "${SFTP_REMOTE_ROOT:=/html}"

export ROOT ENV_FILE SFTP_HOST SFTP_PORT SFTP_USER SFTP_PASSWORD SFTP_REMOTE_ROOT
