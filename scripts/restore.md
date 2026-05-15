# Restoring CSuite Code from this repo

This repo tracks the *customization* layer of a WordPress site. The site itself
(WP core, plugins, theme, uploads) is restored from upstream sources and the DB
dump baseline.

## Bare-metal restore on a new server

### 1. Install LAMP stack and WP-CLI
```bash
apt-get install apache2 mysql-server php php-mysql php-curl php-gd php-mbstring php-xml php-zip
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp && chmod +x /usr/local/bin/wp
```

### 2. Create the database
```bash
mysql -u root -p <<SQL
CREATE DATABASE mysite_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'NEW_STRONG_PASSWORD';
GRANT ALL ON mysite_db.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
SQL
```

### 3. Download WordPress core
```bash
cd /var/www/html
wp core download --allow-root
```

### 4. Create wp-config.php from the template
```bash
cp /path/to/this/repo/config/wp-config.template.php /var/www/html/wp-config.php
```
Edit it and fill in:
- `DB_PASSWORD` — the password you set in step 2
- All 9 auth keys/salts from https://api.wordpress.org/secret-key/1.1/salt/

### 5. Restore the database from the baseline
```bash
gunzip -c /path/to/this/repo/backup/db-baseline-*.sql.gz | wp db import - --allow-root
```

If you have a newer nightly dump from `/var/backups/wordpress/`, prefer that.

### 6. Install the theme and plugins listed in `config/active-plugins.csv`
```bash
wp theme install kadence --activate --allow-root

# Loop the active-plugins.csv (skip the header), install each
tail -n +2 config/active-plugins.csv | awk -F',' '$2 == "active" {print $1}' | while read slug; do
  wp plugin install "$slug" --activate --allow-root
done
```

### 7. Drop the custom mu-plugins back in
```bash
mkdir -p /var/www/html/wp-content/mu-plugins
cp mu-plugins/*.php /var/www/html/wp-content/mu-plugins/
```

### 8. Re-apply Kadence theme mods
```bash
wp option update theme_mods_kadence "$(cat config/theme-mods-kadence.json)" --format=json --allow-root
```

### 9. Re-apply Rank Math settings
```bash
wp option update rank-math-options-titles  "$(cat config/rank-math-titles.json)"  --format=json --allow-root
wp option update rank-math-options-general "$(cat config/rank-math-general.json)" --format=json --allow-root
wp option update rank_math_modules         "$(cat config/rank-math-modules.json)" --format=json --allow-root
wp option update rank_math_registration_skip 1 --allow-root
wp option update rank_math_wizard_completed  1 --allow-root
```

### 10. Re-import uploads (media)
Uploads are NOT in this repo. Restore them from your offsite media backup to:
`/var/www/html/wp-content/uploads/`

### 11. Flush rewrites and verify
```bash
wp option delete rewrite_rules --allow-root
curl -sI https://csuitecode.com/ -o /dev/null -w "HTTP %{http_code}\n"
```

## Restoring just the custom code (no DB wipe)

If the site is up and you only need to roll back custom changes:

```bash
cd /var/www/html/wp-content/mu-plugins/
cp /path/to/repo/mu-plugins/*.php .
```

## Restoring page content from `pages/`

Each file in `pages/` is the raw post_content for a published page. To restore
the content of a single page:

```bash
wp post update <POST_ID> /path/to/repo/pages/<id>-<slug>.html --allow-root
```
