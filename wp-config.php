<?php
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
define( 'DB_NAME', 'api' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '0;9tqK,?ZfBW1xvjllJ._%]xIcj3E!VJ`=.Xm+B$w dSS<^2}#fR}9txgPEZd,pp' );
define( 'SECURE_AUTH_KEY',  'v0F?0ExnP80JgYQZy}am|A<{CKNjaogARm6!ZS-| PS-BxnIdVof~K6}SPk%LY>7' );
define( 'LOGGED_IN_KEY',    'qf{_Xtx7,;1Sa*Mw=c0/x@X31{QrB=GkH6e`O=,,mH#pb-R.AToe2#)_c /?/P%X' );
define( 'NONCE_KEY',        '>$BI_m:}>{[kE?{LE;Btng,D1y~t?V`[l[QC`z1<rZ2I&9bfxe!8:L7<4{lnb,P:' );
define( 'AUTH_SALT',        'Y{!&1;4UqPf|3Y[$l=[^U|udAZ=c$=M0h@)JPnmZ51a)-~P2x^fsEb-3h,.Z];jw' );
define( 'SECURE_AUTH_SALT', '!ZS-=H32i]uuhXG>-Y-<dZ_7{}y#4!;liEP^KlGs{Mp$TZh&aH)2D<_7:!p<s7d!' );
define( 'LOGGED_IN_SALT',   '}3]Q/6o)55VvK>4|BTbf66%T UT:/I^~@b@cTN_a.hKZfO{Y6[V1O$]v4O!/##8t' );
define( 'NONCE_SALT',       'Sl^L,;tCWT.H#iJM>Gx]`qlL`QT,a^N+O3(P!^q8h%q7FDYIv1bCXGgt1OZUv^2&' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
