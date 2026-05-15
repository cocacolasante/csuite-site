#!/usr/bin/env bash
# Nightly WordPress database backup with rotation.
# Drop into /etc/cron.daily/ or run via crontab. Output goes to BACKUP_DIR.

set -euo pipefail

WP_PATH="${WP_PATH:-/var/www/html}"
BACKUP_DIR="${BACKUP_DIR:-/var/backups/wordpress}"
KEEP_DAYS="${KEEP_DAYS:-14}"

mkdir -p "$BACKUP_DIR"
TS=$(date +%Y-%m-%d_%H%M%S)
OUT="$BACKUP_DIR/db-${TS}.sql.gz"

# Dump and compress (relies on wp-cli being on PATH and able to read wp-config.php)
wp --path="$WP_PATH" --allow-root db export - | gzip > "$OUT"

# Restrict access — DB dumps contain user data
chmod 600 "$OUT"

# Rotate
find "$BACKUP_DIR" -name 'db-*.sql.gz' -type f -mtime "+${KEEP_DAYS}" -delete

echo "Backup written: $OUT"
echo "Backups kept:   ${KEEP_DAYS} days"

# Optional offsite sync — uncomment + configure to push backups to S3/Backblaze/etc:
#
# aws s3 sync "$BACKUP_DIR" s3://YOUR-BUCKET/csuite/wp-db/ --exclude '*' --include 'db-*.sql.gz'
# rclone sync "$BACKUP_DIR" remote:csuite/wp-db/
