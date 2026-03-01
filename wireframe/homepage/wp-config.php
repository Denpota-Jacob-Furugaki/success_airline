<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'putinoko49_wp1' );

/** Database username */
define( 'DB_USER', 'putinoko49_wp1' );

/** Database password */
define( 'DB_PASSWORD', 'sjk0s46nr7' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'KI=ddl>bekgrFyWy:9A2id<oXItNy]5[2(W ak<!)IM]B,Y|5B*0y,Y><:yF~av-' );
define( 'SECURE_AUTH_KEY',  '+=/Eg]x!YzL1,7nqY&yd[:_o3v1GxfyDBjJ`12dA`]}eJx,,`OrENuq*5_7d1H%6' );
define( 'LOGGED_IN_KEY',    'S;^^@s;$9 ![y?EE<==|9+qpcFf@u$dX<hSyM?Ul/ D2vjISA]HZ[=Mc+QZ(D:bn' );
define( 'NONCE_KEY',        '|2gb~1G#:v>X|i4X78GX*k!k<*q-(vM0sS-{oy+jKh?|c!_&H|-FU7n6k=;D3Ks{' );
define( 'AUTH_SALT',        'd}L8VX|o_#aQRx@sU+.{(yT+mAe6s:yQxV!dpqoFO*)So3%CBp^9,%w$Hld/(&jb' );
define( 'SECURE_AUTH_SALT', 'Xir@0 |by-fwc~$#0tpjntHlW1iGMO(SzxY.]S>7.n1pn@<]L=qD<@j6N1lPej|z' );
define( 'LOGGED_IN_SALT',   '>i+b#LUy86Rjz@1=gQ9rjf8z.rFBS~ac.:`=}?V{ HNP&vrtRVHe=abQrof95Xe8' );
define( 'NONCE_SALT',       '0E}i{dt$1|=t7m6AVVnfWhro*(&)[Dsdu<znn61}Ihn{#nzv#W)QJg:t7ur`Ys# ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
