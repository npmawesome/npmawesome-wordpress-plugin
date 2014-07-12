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

function npm_def($value, $default) {
  return is_null($value) ? $default : $value;
}

function npm_github_link_html($link) {
  return "<a href='https://github.com/$link'>$link</a>";
}

function npm_module_shortcode($atts) {
  $meta = get_post_custom();
  $npm = yaml_parse($meta['npm'][0]);
  $module = $npm['module'];

  if(is_null($npm) or is_null($module)) {
    return "<div style='background: red; color: white;'>NPM META NOT SET</div>";
  }

  if(!is_array($atts)) {
    $atts = [];
  }

  $a = shortcode_atts($module, $atts);
  $repo = $module['repo'];
  $license = $module['license'];
  $name = npm_def($module['install'], $module['name']);
  $displayName = npm_def($module['displayName'], $name);
  $result = "<a href='http://browsenpm.org/package/$name'>$displayName</a>";

  if(array_search('full', $atts) !== FALSE) {
    if(!is_null($repo)) $info = "GitHub: " . npm_github_link_html($repo);
    if(!is_null($license)) $info = "$info, License: $license";
    $result = "$result <span class='meta'>($info)</span>";
  }

  return "<span class='npm module'>$result</span>";
}

function npm_author_shortcode($atts) {
  $meta = get_post_custom();
  $npm = yaml_parse($meta['npm'][0]);
  $author = $npm['author'];

  if(is_null($npm) or is_null($author)) {
    return "<div style='background: red; color: white;'>NPM META NOT SET</div>";
  }

  if(!is_array($atts)) {
    $atts = [];
  }

  $a = shortcode_atts($module, $atts);
  $github = $author['github'];
  $name = $author['name'];

  if(array_search('photo', $atts) !== FALSE) {
    $author_info = npm_curl_json("https://api.github.com/users/$github");
    $result = "<img src='$author_info[avatar_url]'/>";
  }
  else {
    $result = "<a href='https://github.com/$github'>$name</a>";
  }

  return "<span class='npm author'>$result</span>";
}

add_shortcode('module', 'npm_module_shortcode');
add_shortcode('author', 'npm_author_shortcode');
?>
