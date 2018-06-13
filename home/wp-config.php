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
define('DB_NAME', 'gravitybpx-wp');

/** MySQL database username */
define('DB_USER', 'gravitybpx-wp');

/** MySQL database password */
define('DB_PASSWORD', '92@UwMv)N9IE');

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
define('AUTH_KEY',         'l-1 {j4w5KEvuUPy|KOTA$c>SFbn;.I4%H]5?=(!jUH9isW%:rX]+3`R[{h{Ls,[');
define('SECURE_AUTH_KEY',  'J{e+jEIj3IsF86j&#EsvnMF/M,Llq@<np1%fY$[WU}]S^L/!)$Pt+F9UPAh%q*-E');
define('LOGGED_IN_KEY',    ':eGpHBOqtf<XLpv}8_E%JT?i;j%hvs.ner88-Av#L(r$(<4Uwd}*%}A1fy!)y2Ku');
define('NONCE_KEY',        'lfv.`&^Abf(V6q3ugqi:Eh|MQsme}Y1(y5fqqVl{ga5+qo<;(8]V=)c&UxnAFYd8');
define('AUTH_SALT',        'X!7Tw0}O|c^NttrhIK_Y2,P+zN._o42YVu?7@6&8Bp*?ZY$^m4,Ff#*)HMm[^B58');
define('SECURE_AUTH_SALT', 'f,!:*%Il!YcjLIkp}Z>zFUWme>K.eMf^xU$0V1w1.;e:T& a~D{04q_HA@(rFs0~');
define('LOGGED_IN_SALT',   '!`cYzNmVGiezH91t(w,g;zx~/P{3@Sd/o*3NG#PjVh+r3HGcd*XA&JC5pI$7crSr');
define('NONCE_SALT',       'f!o<3s.`9MFytWeZXwXUDxj(L:hu;dt3n0j&&}1FD*/iQ7_A>_],fdmF=j`B0#MB');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);
define( 'WPCF7_VALIDATE_CONFIGURATION', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
