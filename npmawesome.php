<?php
/*
Plugin Name: npmawesome
Plugin Script: npmawesome.php
Plugin URI: http://npmawesome.com
Description: custom NPMAWESOME stuff
Version: 1.0
Author: Alex Gorbatchev
Author URI: https://github.com/alexgorbatchev

=== DEPENDENCIES ===
http://php.net/manual/en/yaml.installation.php
sudo apt-get install php5-curl
sudo /etc/init.d/apache2 restart

=== RELEASE NOTES ===
2014-07-11 - v1.0 - first version
*/

define('NPM_DIR', dirname(__FILE__));

require_once( join( DIRECTORY_SEPARATOR, array( NPM_DIR, 'common.php' ) ) );
require_once( join( DIRECTORY_SEPARATOR, array( NPM_DIR, 'module.php' ) ) );
require_once( join( DIRECTORY_SEPARATOR, array( NPM_DIR, 'author.php' ) ) );
require_once( join( DIRECTORY_SEPARATOR, array( NPM_DIR, 'partner.php' ) ) );
