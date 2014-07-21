<?php
/*
[author] -> will print author name
[author photo] will display author github profile photo
*/

function npm_author_shortcode($atts) {
  if(!is_array($atts)) {
    $atts = [];
  }

  $github = get_field('module_github');
  $github = substr($github, 0, strpos($github, '/'));
  $github_info = npm_curl_json("https://api.github.com/users/$github");

  if(array_search('photo', $atts) !== FALSE) {
    $result = "<img src='$github_info[avatar_url]' width='200' align='right' vspace='10' hspace='10'/>";
  }
  else {
    $result = "<a href='https://github.com/$github'>$github_info[name]</a>";
  }

  return "<span class='npm author'>$result</span>";
}

add_shortcode('author', 'npm_author_shortcode');
?>
