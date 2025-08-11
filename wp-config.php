<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'intrasalud_wp200' );

/** Database username */
define( 'DB_USER', 'intrasalud_wp200' );

/** Database password */
define( 'DB_PASSWORD', 'S-@NQp44P0' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('DISABLE_WP_CRON', true);

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0y0jwebzgg3ok2orgcvwutwyr7cfgegbfrbchukhh7iksztlrowdsiongmyckdah' );
define( 'SECURE_AUTH_KEY',  'wr5wnqqgidjosvb64vuuvvxki5tqdvjp9ovt9lo0pi6y2auheniaqwbspef4ah1y' );
define( 'LOGGED_IN_KEY',    'q7dpkfojbibyppx4nv8w5ngwpfhsincvfuqxl3vhraych9eodjv8wtl40npuhynk' );
define( 'NONCE_KEY',        'w5ufkepchhwe7xyygkjhp4xcduwiwd3ixzvqrxb9fglm0pyzxpuiwix6fnbnneo9' );
define( 'AUTH_SALT',        'd7ba9ipfcgzxw2hav4gw2diaqlgiwzdbiogiby1iajgsffnfu1c5clo6n9sufi8c' );
define( 'SECURE_AUTH_SALT', '68x8cmetd3grjphouey68mcyhnxeegz3rgjrz6mrrc8fmrbdghnrjxtqzsbd5uf4' );
define( 'LOGGED_IN_SALT',   'spaugdfmxt2jdftjnlxmgky6aitwqmh8pbbewfwftzryblom1tyowdlhij8eojop' );
define( 'NONCE_SALT',       'tvjngt1w4hhmd0jrnrhkaxaihdj9wef4ihq2v8c5bx2obamibv1aa3ek8kid1fkg' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpvx_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';