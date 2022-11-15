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
define( 'DB_NAME', 'weblms' );

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
define( 'AUTH_KEY',         '4/n(SKph&QxGgm]]hJ,SdGNv(6S@f<4)Z250gn/5X76^.x^by!U/&ht)0{!;;Y0,' );
define( 'SECURE_AUTH_KEY',  '%egm6;TN(v`!0B)ZTg7lLp??GqJ(=0&hNbBsmEL+?38dv?#xF%<loE8xL{JGI.*;' );
define( 'LOGGED_IN_KEY',    'r29$A|6aqD)mq<<G2*g_a~Vv`rY>;>KL0Mh7*&?bRdV;^u#[XLJaMp47v$Yac4cB' );
define( 'NONCE_KEY',        'QnOswlLf}=~9r=U|;dpcys3*<h<X]v+#8$BB9OPV[^N[vPteE`JM7.:2.a29}Bp+' );
define( 'AUTH_SALT',        '50HRC7KZ:(M0 eyF98,cK4qDn(Fv`rk5Hb/h~V*c,t?&Hs-OO<DPuzsR*{WLb/Pf' );
define( 'SECURE_AUTH_SALT', '+ZMS{(xI7|A&=;pA;4ZM%62C^LB3VGjRFVdw1o!?jS~Z;}HC=yR-pB.a.Z/bc{/g' );
define( 'LOGGED_IN_SALT',   'flSz,XN07VbNe.R0JQj>`[[4wYvTu7X+b-(GB&IIB|gi`v}v4l0*ZrR_=G??Ae=K' );
define( 'NONCE_SALT',       'o;^@B,GB!sy`1W4lLk#B[[c.YmSi!wLF]@u/!RE8dAYhDo%`zDZKgnnC%v-(yGF%' );

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
