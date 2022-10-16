<?php
define( 'WP_CACHE', true );
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u339464572_nEwNd' );

/** Database username */
define( 'DB_USER', 'u339464572_B3ZIV' );

/** Database password */
define( 'DB_PASSWORD', 'EyPOvwOfqu' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',          '5g:hKawl#^U^Z:^uUSq8x&#(g!|[nZjyS w}r}gz5j&Oh-D#Flu|c^Yt<NT,`F7o' );
define( 'SECURE_AUTH_KEY',   'qa)=Xo.Q_+1*YPg<$9}`#y2d|o7oCfwL&;J]`J8$h Ln8^]}1Khas#jaE~`*3Xm<' );
define( 'LOGGED_IN_KEY',     '1*TJhi1CWZz1FNF/1|MU)TlD(iQUTH/[VO4JDP#NC}f36%!eL_,;jm>H!J4Nh>Kq' );
define( 'NONCE_KEY',         ' L%6!<:tK;;Y]t|q,:k,xJ9@Kf{=srAt4ZPy1,pHLkEpxq-Ox7j9WeA #Sz,h*<<' );
define( 'AUTH_SALT',         'sLg!w04xh`$VCfq$E@qJ+*rsL>&t?KL8#C:MZwZxu;4?YE<,i3#:jDN>`-$K22#p' );
define( 'SECURE_AUTH_SALT',  '3UHqmpeb7)IKZ6fe<WWmG,2+6t,Ome5eUv*Bi(5.Bsf]a2i~)$U!Y5tH<!Z/,xXy' );
define( 'LOGGED_IN_SALT',    ',?yCjGzzRl;ucUP*SN^l:Z;L%nR(tnDtk5&zQl9gOCDatdiDmfnKm4xnFe@wlWSl' );
define( 'NONCE_SALT',        'p?A|)f*EInX7`/n*)Nz=].L,bJ*D0sNh-St#RO$%g6knt6HPxk1|ASk2RxRWx[ur' );
define( 'WP_CACHE_KEY_SALT', 'og{#=-GEqz]U7qm2q^[rWAlx{7s8+FbgY HL*uDF1)?ST~ :FIO6~BB=TOyYjIoy' );


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



define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
