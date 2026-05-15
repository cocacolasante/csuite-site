# CSuite Code — site backup and customizations

This is a **private** backup repository for [csuitecode.com](https://csuitecode.com)
— a WordPress site running the Kadence theme.

It tracks the *custom layer* of the site: bespoke mu-plugins, sanitized config,
configuration snapshots, page content exports, and a one-time database baseline.

WordPress core, third-party plugin code, and media uploads are **not** in this
repo. They're recoverable from their original sources plus the steps in
[`scripts/restore.md`](scripts/restore.md).

## Repo layout

```
.
├── README.md
├── .gitignore
├── mu-plugins/                # Custom must-use plugins (the heart of the site)
│   ├── csuite-schema.php      # Organization/Service/FAQ/HowTo JSON-LD, related-services block
│   └── csuite-style-polish.php
├── pages/                     # Per-page post_content exports (raw block markup)
│   ├── 57-home.html
│   ├── 58-about.html
│   └── ...
├── config/                    # Configuration snapshots
│   ├── wp-config.template.php # Sanitized template — fill in DB creds + salts on restore
│   ├── active-plugins.csv     # Plugin manifest for re-install
│   ├── active-theme.txt
│   ├── theme-mods-kadence.json
│   ├── rank-math-titles.json
│   ├── rank-math-general.json
│   ├── rank-math-modules.json
│   ├── primary-menu.json
│   ├── site-url.txt
│   └── blog-name.txt
├── backup/
│   └── db-baseline-YYYY-MM-DD.sql.gz   # One-time DB dump baseline
└── scripts/
    ├── db-backup.sh           # Cron-friendly nightly DB dump (run on the server)
    └── restore.md             # Full restore instructions
```

## Quick restore reference

Full instructions: [`scripts/restore.md`](scripts/restore.md)

Quick rollback of *just* the custom code:
```bash
cd /var/www/html/wp-content/mu-plugins/
cp /path/to/repo/mu-plugins/*.php .
```

## Setting up the nightly DB backup on the server

```bash
sudo cp scripts/db-backup.sh /usr/local/bin/wp-db-backup
sudo chmod +x /usr/local/bin/wp-db-backup

# Cron: nightly at 03:00, write to /var/backups/wordpress/
sudo crontab -e
# Add:
0 3 * * * /usr/local/bin/wp-db-backup >> /var/log/wp-backup.log 2>&1
```

Backups land in `/var/backups/wordpress/` with 14-day rotation. **These are not
committed to git** — they're for the server only. Configure the optional
`aws s3 sync` block at the bottom of `db-backup.sh` to push them offsite.

## Updating the snapshot

When you make notable changes (custom code, theme mods, page edits), refresh
the relevant snapshot files and commit:

```bash
cd /root/csuite-site

# Refresh mu-plugins
cp /var/www/html/wp-content/mu-plugins/*.php mu-plugins/

# Refresh a single page
PID=288; SLUG=$(wp --path=/var/www/html --allow-root post get $PID --field=post_name)
wp --path=/var/www/html --allow-root post get $PID --field=post_content > pages/${PID}-${SLUG}.html

# Refresh theme mods
wp --path=/var/www/html --allow-root option get theme_mods_kadence --format=json \
  | python3 -m json.tool > config/theme-mods-kadence.json

git add -A
git commit -m "Snapshot: <describe what changed>"
git push
```

## Security notes

- `wp-config.php` is `.gitignore`d. Never commit real DB passwords, auth keys,
  or salts to this repo.
- The DB baseline dump contains all post content, user accounts, FluentCRM
  contacts, and any WooCommerce orders. Even though this repo is private,
  treat it as sensitive — don't share access lightly.
- The `uploads/` folder is excluded. Back up media separately to object storage.
- Rotate WP auth salts and the DB password if you suspect any leakage. Auth
  salts can be regenerated at <https://api.wordpress.org/secret-key/1.1/salt/>.

## Stack summary

- **WordPress** site at `csuitecode.com`
- **Theme:** Kadence (free, downloadable from wp.org)
- **Active plugins** (see `config/active-plugins.csv`): Fluent CRM, Fluent Forms,
  Fluent SMTP, Kadence Blocks, Google Site Kit, Kadence Starter Templates,
  WooCommerce, Rank Math SEO
- **Custom code** (see `mu-plugins/`): site schema enrichments, FAQ rendering,
  related-services injection, and visual style polish
