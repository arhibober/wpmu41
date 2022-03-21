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
define('DB_NAME', 'wpmu41');

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
define('AUTH_KEY',         '|QAq0W}Z!B-DOt_0Rd=-k23~|a+yBdz_mBjO *[18)% @MNH+N~P/;VM%v4/pY+M');
define('SECURE_AUTH_KEY',  'JFj[%=&[=-twxmo/j5dJ|.;@x)anys4<::u O+?*7}p@E,N+X6) f0jm/nm4wPQq');
define('LOGGED_IN_KEY',    '7|!-h9#AbM4B?(1Z`gw]>?Yc>NBs4o6z&PDA:|_eSX!t#4u*fk=F6)}+-n;/a,?h');
define('NONCE_KEY',        'zKK #Y^]y+!3H9-+r8fkM|dU$zAeTd-!h{7SPT&nZuGq|.pqX2!v.AUz6#Vf(wTo');
define('AUTH_SALT',        'A6G}boJ`kRxph[*L%1:IZt]-[, xvc5_JGE`OpF;WAC0[A<TEl(>J&;f-#OmoRml');
define('SECURE_AUTH_SALT', 'k.l_3GcDUwAL(Hd; C%(7&ojNiqgE5rM4C0{WpG4P<iv8GTjRh:I7#pM0rQwk<~A');
define('LOGGED_IN_SALT',   '++T}d.,/_O`08AINJ00N0<@$+3&yQ;(/ijMevK4j%K>-m]%YNTE]S ;IXh#V^B3^');
define('NONCE_SALT',       'c)m;sHyDJsf&&d;qA51_]&rSg-IRx` )sz~AiJ_KyQD.+_)A{jSF/c3J4QJEuglw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/wpmu41/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('WP_ALLOW_MULTISITE', true);
define ('WPLANG', 'uk');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
