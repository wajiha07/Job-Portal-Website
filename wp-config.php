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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u458904137_temp29' );

/** Database username */
define( 'DB_USER', 'u458904137_temp29' );

/** Database password */
define( 'DB_PASSWORD', 'Wajiha123#4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'jn,n+=NQ,|NN3_unQ^|oZSmL9g`lD|/RKVXf1xBGP`FO=?BO(4e540g]cZUfm]Hy' );
define( 'SECURE_AUTH_KEY',  'A_{;ff$`?rPCZ-dI#B.@E%-|^yxB ?9TS{P[ZAsEMzL0Mr-z?|mjBD9t~^O%3jfw' );
define( 'LOGGED_IN_KEY',    'G=H C]hS-v*H@V&w:$ONqm3IHS$~D7sin~s(gda44u~e!6hhG2 v+BP:I^iEu8u:' );
define( 'NONCE_KEY',        ' rLmtE dz,z@]%Lgm#vd1G@>`e;UD+R[^e3Zh ]uyO[.u$h`Lh#B=JCbpiAUbXyF' );
define( 'AUTH_SALT',        'rs!Sj> 6wI0gB6L!%U;Z)J_otDk9e2^`m]wy^f;t~Fw1g`dmpL%c!mvMksQc@^/&' );
define( 'SECURE_AUTH_SALT', '%}72+$baxh6D-8?%H/W)JDk&F(U7`_YZKj6Ov,~D,Tj`$<[%#LV+BfE(dk)L?eY~' );
define( 'LOGGED_IN_SALT',   'Z/YuxoMhPBd 7i1`+ORQt:NI@0a8}p n[u#$DoX|@[x[&@f3V9}Vsfa]Dh3):hn_' );
define( 'NONCE_SALT',       'fB5hy^_v#38?K{lZ0:?$lH]lMcvuLA4dvycmJPw=C&EdDZqPP#A-ytUHN$dLU:rD' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
