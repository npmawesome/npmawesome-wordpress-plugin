<?php
/*
[module] -> will print browsenpm link
[module full] -> will print browsenpm link, github and license
[module name="gulp-print" github="alexgorbatchev/gulp-print" license="boo"]
[module name="gulp-print" github="alexgorbatchev/gulp-print" license="boo" full]
*/

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

add_shortcode('module', 'npm_module_shortcode');
?>
