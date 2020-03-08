<?php
define( "DB_NAME", "wordpress" );
define( "DB_USER", "root" );
define( "DB_PASSWORD", "New@Store5000New@New" );
define( "DB_HOST", "localhost" );
define( "DB_CHARSET", "utf8mb4" );
define( "DB_COLLATE", "" );
define( "AUTH_KEY",         "8m4]?D*ZnJ|jhvbm#;C?|9@oi-e`$3@H:?qmok6WmiXG@Bo-zw:pb^A.9~Kq+|4i" );
define( "SECURE_AUTH_KEY",  "4tgfSp?YJ$%Gj6jcB1Lm>7zY&ix&:xIB:Bd&T7)Blokun{4uHn:ti,;&cqs2k<fb" );
define( "LOGGED_IN_KEY",    "5w|r>e|ja9ZtUp,Q,{H{}PxT1_D29:2Wm%=>!~8gc#CQVcn3VRkfDLn+]@Hua8DY" );
define( "NONCE_KEY",        "S#9D?=iNyO0Q>]@foU.(3,.>(D!=e:|G!+B|o:}s~9OK5XrMR(wP!,,j0[gk8`I#" );
define( "AUTH_SALT",        "K84U7}qIGA1(npdpJyT15A:5<&OZ2cs)<W[@&-byMl:#_UL.J9A6Zbs[.*!~mieE" );
define( "SECURE_AUTH_SALT", "9L>tuxT=+!7bnMQ9Q`5F<P*Dc#$,A]uT$vw84+~(A6Zd8cOq1]+J G`L~wYz|-{8" );
define( "LOGGED_IN_SALT",   " @(Z|@!xYtY{1>{@EIJ`aMMr3uk`hWRUx/$keQbXAF(p]cDio=Fj#.&lE8vW+upP" );
define( "NONCE_SALT",       "rswy&^j+JY^|%>CK>v)$@tdZU?q[ip`&B4? Q&Q!grolu-i:&FCA).Z2<jAh|,[l" );

// define( "FS_METHOD", "ssh2" );
// define( "FTP_BASE", "/var/www/storecreator.io/script/" );
// define( "FTP_CONTENT_DIR", "/var/www/storecreator.io/script/wp-content/" );
// define( "FTP_PLUGIN_DIR ", "/var/www/storecreator.io/script/wp-content/plugins/" );
// define( "FTP_PUBKEY", "/home/username/.ssh/id_rsa.pub" );
// define( "FTP_PRIKEY", "/home/username/.ssh/id_rsa" );
// define( "FTP_USER", "root" );
// define( "FTP_PASS", "New@Store5000New@New" );
// define( "FTP_HOST", "163.172.57.36" );
// define( "FTP_SSL", false );


$table_prefix = "wp_";
define( "WP_DEBUG", false );
if ( ! defined( "ABSPATH" ) ) {
	define( "ABSPATH", dirname( __FILE__ ) . "/" );
}
require_once( ABSPATH . "wp-settings.php" );