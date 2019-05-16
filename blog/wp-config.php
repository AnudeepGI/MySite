<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mysite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'pt3yBNEXLkMyqxP4' );

/** MySQL hostname */
define( 'DB_HOST', '104.225.221.66' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ItYL$^]6?BJnI#$Q_E< My1_uo;F0bq6V~phq^R-rkfnDqDYE,aR9WG{=_**s!KS' );
define( 'SECURE_AUTH_KEY',  '+ztI{| M YJ;~o*1b{L{$^<IJ#2(>%Eg+pG`MLyfCX/$JTTBn8?lS{TAReO;Cbu[' );
define( 'LOGGED_IN_KEY',    '|uf;}^BHWi39ku6GozSw/>@)AS=(h~=sNmVjsl(vcLhUKzZ=W_b?>/NZrDz8%&tM' );
define( 'NONCE_KEY',        'g)AgS;eVKfu=-G{3*AucVJyN.w|[[}QQ;nKo*2FVA *,!-gp^UG@YRbPSXkF5C*r' );
define( 'AUTH_SALT',        ']A*K]Og^`7jH$PVJW;zR$L|YUF4^NdzP>vOLm7.vlKq6cm#b/?>dQZ(3 ^ym*u9a' );
define( 'SECURE_AUTH_SALT', '%6BUjn&3y&M@U&!F>JTw!G`)0pE=E0POrK(=gg]7(4sH5$r$yR8^bV+WWvFFxc;{' );
define( 'LOGGED_IN_SALT',   'w+GdbCgyUe9wk+K)-t7%Unl*{$ :ZxKbQn3`;[_|&BzuVuk$!RKX ?R8D%v1prur' );
define( 'NONCE_SALT',       'l^6-9[/3u~~V!#_u/HnfQCI8de8gJdPO7Qx*oe0VzlW2M*;dhR_FWgYj1c_D}5cv' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

