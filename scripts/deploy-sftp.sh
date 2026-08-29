#!/usr/bin/env bash
# Deploy approved custom code from this repo to Elementor Cloud via SFTP.
#
# Safety: refuses to run unless you pass --yes (explicit approval).
#
# Usage:
#   ./scripts/deploy-sftp.sh --yes                 # deploy child theme + plugins with code
#   ./scripts/deploy-sftp.sh --yes --theme-only    # child theme only
#   ./scripts/deploy-sftp.sh --yes --plugins-only  # plugins only
#   ./scripts/deploy-sftp.sh --dry-run             # print plan, no upload
#
set -euo pipefail
source "$(cd "$(dirname "$0")" && pwd)/lib-env.sh"

YES=0
DRY_RUN=0
THEME_ONLY=0
PLUGINS_ONLY=0

for arg in "$@"; do
  case "$arg" in
    --yes|-y) YES=1 ;;
    --dry-run) DRY_RUN=1 ;;
    --theme-only) THEME_ONLY=1 ;;
    --plugins-only) PLUGINS_ONLY=1 ;;
    -h|--help)
      sed -n '2,12p' "$0"
      exit 0
      ;;
    *)
      echo "Unknown arg: $arg" >&2
      exit 2
      ;;
  esac
done

if [[ "$YES" -ne 1 && "$DRY_RUN" -ne 1 ]]; then
  cat <<EOF >&2
Refusing to deploy without explicit approval.

This protects the live site. After you review git diffs / commits:

  ./scripts/deploy-sftp.sh --dry-run   # preview
  ./scripts/deploy-sftp.sh --yes       # upload to Elementor Cloud

EOF
  exit 1
fi

CHILD_THEME_LOCAL="${ROOT}/custom/theme/dabbuilds-child"
CHILD_THEME_REMOTE="${SFTP_REMOTE_ROOT}/wp-content/themes/dabbuilds-child"
PLUGINS_LOCAL="${ROOT}/custom/plugins"
PLUGINS_REMOTE="${SFTP_REMOTE_ROOT}/wp-content/plugins"

CMDS=()

plan_theme() {
  if [[ ! -d "${CHILD_THEME_LOCAL}" ]]; then
    echo "No child theme at ${CHILD_THEME_LOCAL} — skip theme"
    return
  fi
  echo "Theme:  ${CHILD_THEME_LOCAL}  ->  ${CHILD_THEME_REMOTE}"
  CMDS+=("mkdir ${CHILD_THEME_REMOTE}")
  while IFS= read -r -d '' f; do
    rel="${f#${CHILD_THEME_LOCAL}/}"
    [[ "$(basename "$f")" == ".gitkeep" ]] && continue
    mkdir_parents "${CHILD_THEME_REMOTE}" "$(dirname "$rel")"
    CMDS+=("put ${f} ${CHILD_THEME_REMOTE}/${rel}")
  done < <(find "${CHILD_THEME_LOCAL}" -type f -print0 | sort -z)

  # Elementor serves .jpg from the web root, not via theme PHP. Mirror the
  # game there so /play/v2/assets/*.jpg is a real file instead of a 302.
  PLAY_LOCAL="${CHILD_THEME_LOCAL}/play"
  PLAY_REMOTE="${SFTP_REMOTE_ROOT}/play"
  if [[ -d "${PLAY_LOCAL}" ]]; then
    echo "Play:   ${PLAY_LOCAL}  ->  ${PLAY_REMOTE}"
    CMDS+=("mkdir ${PLAY_REMOTE}")
    while IFS= read -r -d '' f; do
      rel="${f#${PLAY_LOCAL}/}"
      mkdir_parents "${PLAY_REMOTE}" "$(dirname "$rel")"
      CMDS+=("put ${f} ${PLAY_REMOTE}/${rel}")
    done < <(find "${PLAY_LOCAL}" -type f -print0 | sort -z)
  fi
}

mkdir_parents() {
  local root="$1"
  local rel="$2"
  local dir="$root"
  [[ "$rel" == "." || -z "$rel" ]] && return
  local IFS=/
  local part
  for part in $rel; do
    [[ -z "$part" ]] && continue
    dir="${dir}/${part}"
    CMDS+=("mkdir ${dir}")
  done
}

plan_plugins() {
  if [[ ! -d "${PLUGINS_LOCAL}" ]]; then
    return
  fi
  shopt -s nullglob
  for plugin_dir in "${PLUGINS_LOCAL}"/*/; do
    name="$(basename "$plugin_dir")"
    if ! find "$plugin_dir" -type f \( -name '*.php' -o -name '*.js' -o -name '*.css' \) | grep -q .; then
      echo "Plugin skip (no code): ${name}"
      continue
    fi
    remote="${PLUGINS_REMOTE}/${name}"
    echo "Plugin: ${plugin_dir}  ->  ${remote}"
    CMDS+=("mkdir ${remote}")
    while IFS= read -r -d '' f; do
      rel="${f#${plugin_dir}}"
      [[ "$(basename "$f")" == ".gitkeep" ]] && continue
      if [[ "$(dirname "$rel")" != "." ]]; then
        CMDS+=("mkdir ${remote}/$(dirname "$rel")")
      fi
      CMDS+=("put ${f} ${remote}/${rel}")
    done < <(find "$plugin_dir" -type f -print0 | sort -z)
  done
}

echo "=== Deploy plan (Elementor Cloud SFTP) ==="
echo "Host:   ${SFTP_USER}@${SFTP_HOST}:${SFTP_PORT}"
echo "Root:   ${SFTP_REMOTE_ROOT}"
echo

if [[ "$PLUGINS_ONLY" -eq 1 ]]; then
  plan_plugins
elif [[ "$THEME_ONLY" -eq 1 ]]; then
  plan_theme
else
  plan_theme
  plan_plugins
fi

if [[ ${#CMDS[@]} -eq 0 ]]; then
  echo "Nothing to deploy."
  exit 0
fi

echo
echo "SFTP commands (${#CMDS[@]}):"
printf '  %s\n' "${CMDS[@]}"
echo

if [[ "$DRY_RUN" -eq 1 ]]; then
  echo "Dry run only — no files uploaded."
  exit 0
fi

BATCH="$(mktemp)"
{
  for c in "${CMDS[@]}"; do
    printf '%s\n' "$c"
  done
} > "${BATCH}"

echo "Uploading..."
export SFTP_HOST SFTP_PORT SFTP_USER SFTP_PASSWORD BATCH
expect <<'EOF'
set timeout 180
set host $env(SFTP_HOST)
set port $env(SFTP_PORT)
set user $env(SFTP_USER)
set password $env(SFTP_PASSWORD)
set batch $env(BATCH)
log_user 1
spawn sftp -oStrictHostKeyChecking=accept-new -oPreferredAuthentications=password -oPubkeyAuthentication=no -P $port ${user}@${host}
expect {
  -re {[Pp]assword:} { send -- "$password\r" }
  timeout { puts stderr "TIMEOUT password"; exit 1 }
}
expect {
  -re {sftp>} {}
  -re {[Pp]ermission denied} { puts stderr "AUTH FAILED"; exit 1 }
  timeout { puts stderr "TIMEOUT auth"; exit 1 }
}
set fp [open $batch r]
while {[gets $fp line] >= 0} {
  if {$line eq ""} { continue }
  send -- "$line\r"
  expect {
    -re {sftp>} {}
    timeout { puts stderr "TIMEOUT on: $line"; exit 1 }
  }
}
close $fp
send "bye\r"
expect eof
EOF

rm -f "${BATCH}"
echo
echo "Deploy finished."
echo "If this was the first theme deploy, activate in WP Admin:"
echo "  Appearance → Themes → DAB Builds Child"
echo "Verify: https://dabbuilds.com"
