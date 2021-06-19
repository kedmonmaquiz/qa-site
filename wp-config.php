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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'qa' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '8D>_MUw]aqv`fnwqzxY|`pNXnPtJ/u}2IOj:##>:`r*2t%g!]@8EF%.#TCh_jV6y' );
define( 'SECURE_AUTH_KEY',  '~hUmsk6-RS6t.3uea5apoSFCUJm+%{sk#So/kgRArst8;,dI|3UOXOi|(3Dbj|R(' );
define( 'LOGGED_IN_KEY',    '_z/5UIcg{ekHlfo8r2sl9Y!wF+j7k*bz3:<VD|p2O*&QakD#QK]c^|S fJ9^bhJL' );
define( 'NONCE_KEY',        'RWiP/[FJmZ1=&j6ar&KE:QZq[9.BG`5H:15wG|BqGDQ6-*xYJk;eBK_&DfJkofz*' );
define( 'AUTH_SALT',        't=HPB?Nl^g)8.pFFBH$nM ~FvrPJM/S^2Ri2P4;`C*okIy^canwOD4[4#fS_-H)m' );
define( 'SECURE_AUTH_SALT', '>ma%P mZ|_Vs?}f^1^wmMi}+2OiF_i4o6!G&v(@DV#tw$.B6%;Xci4X0+qMw>i[K' );
define( 'LOGGED_IN_SALT',   '$}M&5O|AvD;H=-aq$!Ss;+a!F=a4dcqDzONlAiL$Z<Kkl#qc QkaTsxwiDnHMU#3' );
define( 'NONCE_SALT',       'F)#~QF}1 Nus:-WCeQ%aSYooH3j9}L],Xu>W{w2xmI6dpO,2u96-8qAVD|rZjX`8' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
