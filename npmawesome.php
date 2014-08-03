<?php
/*
Plugin Name: npmawesome
Plugin Script: npmawesome.php
Plugin URI: https://github.com/npmawesome/npmawesome-wordpress-plugin
Description: custom NPMAWESOME stuff
Version: 1.0
Author: Alex Gorbatchev
Author URI: https://github.com/alexgorbatchev
GitHub Plugin URI: npmawesome/npmawesome-wordpress-plugin
GitHub Branch: master

=== DEPENDENCIES ===
http://php.net/manual/en/yaml.installation.php
sudo apt-get install php5-curl
sudo /etc/init.d/apache2 restart

=== RELEASE NOTES ===
2014-07-11 - v1.0 - first version
*/

define('NPM_DIR', dirname(__FILE__));

require_once(NPM_DIR.'common.php');
require_once(NPM_DIR.'module.php');
require_once(NPM_DIR.'author.php');
require_once(NPM_DIR.'partner.php');
require_once(NPM_DIR.'widgets/github-author/index.php');

// replace the default posts feed with feedburner
function npmawesome_custom_rss_feed($output, $feed) {
  if(strpos($output, 'comments'))
    return $output;

  return esc_url('http://feeds.feedburner.com/npmawesome');
}

add_action('feed_link', 'npmawesome_custom_rss_feed', 10, 2);

add_action('widgets_init', function() {
  register_widget('NA_Widget_Github_Author');
});
