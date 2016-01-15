<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dev_naturel');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-ZhUH[wr7<?Y`T:3AT,:x>1BN[0Ys4;B!hF64kM?a wVB#GqSF@G$jk @Hg1jin)');
define('SECURE_AUTH_KEY',  '=-4aW4h15-<S2 z,U5_-FM#5X4hr($EQ ,n%o9o%V<1&.9=+I{`Yo~)-isPGj`6n');
define('LOGGED_IN_KEY',    '{3/ZwE?C.&5il+Phfm@~-|N-FkAMuFMS}qnvn@:nZr~Wj#dO_-IIGe|YOz2P;0[A');
define('NONCE_KEY',        'BjLY|P2{-24?RZ|BsvEM|Lp |q&T6~R*TupU-$9lyHx8/6>a ]Pwg7cDNa>tL3.g');
define('AUTH_SALT',        '~pVti;-&L2%`1UjqVXv~Z?8B7eRb4W6I![$JdB[D-<rl%?-0L~:1J==bHe,M|ySy');
define('SECURE_AUTH_SALT', '+ef>hIC=$.Q|-+/da]O+iOu,)#|6N$dN:F-/TfOsux-aUH|xaMpQcvQizY}jgZgS');
define('LOGGED_IN_SALT',   'ufxFn6)4s3s/^&9H@mR(Rk+g7Dofb7)(yIIl<4&+|^*F~#o}39QvGCnu$^[cr&IX');
define('NONCE_SALT',       'Ws!4-I|rI2NJ?vT{D2d0R}Q+-anG7CEhNS%`C27D]PU{fE!W*)u~@s*#7n|3<,M:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
