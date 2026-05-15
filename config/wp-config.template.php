<?php
/**
 * Sanitized wp-config.php template for CSuite Code.
 *
 * RESTORE STEPS:
 *   1. Copy this file to /var/www/html/wp-config.php
 *   2. Fill in the values marked REPLACE_ME
 *   3. Generate fresh auth keys at https://api.wordpress.org/secret-key/1.1/salt/
 *
 * NEVER commit a wp-config.php with real secrets to git.
 *
 * @package WordPress
 */

// ** Database settings ** //
define( 'DB_NAME',     'REPLACE_ME_DB_NAME' );
define( 'DB_USER',     'REPLACE_ME_DB_USER' );
define( 'DB_PASSWORD', 'REPLACE_ME_DB_PASSWORD' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8' );
define( 'DB_COLLATE',  '' );

/**#@+
 * Authentication unique keys and salts.
 * Generate fresh values at: https://api.wordpress.org/secret-key/1.1/salt/
 */
define( 'AUTH_KEY',          'REPLACE_ME_AUTH_KEY' );
define( 'SECURE_AUTH_KEY',   'REPLACE_ME_SECURE_AUTH_KEY' );
define( 'LOGGED_IN_KEY',     'REPLACE_ME_LOGGED_IN_KEY' );
define( 'NONCE_KEY',         'REPLACE_ME_NONCE_KEY' );
define( 'AUTH_SALT',         'REPLACE_ME_AUTH_SALT' );
define( 'SECURE_AUTH_SALT',  'REPLACE_ME_SECURE_AUTH_SALT' );
define( 'LOGGED_IN_SALT',    'REPLACE_ME_LOGGED_IN_SALT' );
define( 'NONCE_SALT',        'REPLACE_ME_NONCE_SALT' );
define( 'WP_CACHE_KEY_SALT', 'REPLACE_ME_WP_CACHE_KEY_SALT' );
/**#@-*/

$table_prefix = 'wp_';

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'production' );
define( 'WP_HOME',    'https://csuitecode.com/' );
define( 'WP_SITEURL', 'https://csuitecode.com' );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
