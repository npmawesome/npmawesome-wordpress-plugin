<?php
/*
Plugin Name: npmawesome
Plugin Script: npmawesome.php
Plugin URI: http://npmawesome.com
Description: custom NPMAWESOME stuff
Version: 1.0
Author: Alex Gorbatchev
Author URI: https://github.com/alexgorbatchev

[module] -> will print browsenpm link
[module full] -> will print browsenpm link, github and license
[module name="gulp-print" github="alexgorbatchev/gulp-print" license="boo"]
[module name="gulp-print" github="alexgorbatchev/gulp-print" license="boo" full]

[author] -> will print author name
[author photo] will display author github profile photo

=== DEPENDENCIES ===
http://php.net/manual/en/yaml.installation.php
sudo apt-get install php5-curl
sudo /etc/init.d/apache2 restart

=== RELEASE NOTES ===
2014-07-11 - v1.0 - first version
*/

function npm_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_REFERER, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: npmawesome.com"));
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function npm_curl_json($url) {
  $file = realpath(dirname(__FILE__)).'/cache/'.md5($url);

  if(file_exists($file)) {
    return json_decode(file_get_contents($file), true);
  }
  else {
    $json = json_decode(npm_curl($url), true);
    file_put_contents($file, json_encode($json));
    return $json;
  }
}

function npm_github_link_html($link) {
  return "<a href='https://github.com/$link'>$link</a>";
}

function npm_module_shortcode($atts) {
  if(!is_array($atts)) {
    $atts = [];
  }

  $a = shortcode_atts(array(name => '', github => '', license => '', displayName => ''), $atts);
  $name = $a['name'] ?: get_field('module_name');
  $displayName = $a['displayName'] ?: $a['name'] ?: get_field('module_display_name') ?: $name;
  $github = $a['github'] ?: get_field('module_github');
  $license = $a['license'] ?: get_field('module_license');

  if(array_search('install', $atts) !== FALSE) {
    $result = "<span class='install'>npm install $name</span>";
  }
  else {
    $result = "<a href='http://browsenpm.org/package/$name'>$displayName</a>";
  }

  if(array_search('full', $atts) !== FALSE) {
    if(!is_null($github)) $info = "GitHub: " . npm_github_link_html($github);
    if(!is_null($license)) $info = "$info, License: $license";
    $result = "$result <span class='meta'>($info)</span>";
  }

  return "<span class='npm module'>$result</span>";
}

function npm_author_shortcode($atts) {
  if(!is_array($atts)) {
    $atts = [];
  }

  $github = get_field('module_github');
  $github = substr($github, 0, strpos($github, '/'));
  $github_info = npm_curl_json("https://api.github.com/users/$github");

  if(array_search('photo', $atts) !== FALSE) {
    $result = "<img src='$github_info[avatar_url]'/>";
  }
  else {
    $result = "<a href='https://github.com/$github'>$github_info[name]</a>";
  }

  return "<span class='npm author'>$result</span>";
}

add_shortcode('module', 'npm_module_shortcode');
add_shortcode('author', 'npm_author_shortcode');
?>
