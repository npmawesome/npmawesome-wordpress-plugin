<?php
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

function npm_get_github_info($post_id) {
  $post_id = $post_id ?: get_the_ID();
  $cache_key = "npm_github_info_$post_id";
  $github_info = wp_cache_get($cache_key);

  if($github_info !== FALSE) {
    return $github_info;
  }

  $github = get_field('module_github', $post_id);

  if(empty($github)) {
    return null;
  }

  $github = substr($github, 0, strpos($github, '/'));
  $github_info = npm_curl_json("https://api.github.com/users/$github");

  wp_cache_set($cache_key, $github_info);

  return $github_info;
}

function npm_get_github_field($field_name, $post_id) {
  $github_info = npm_get_github_info($post_id);
  return $github_info[$field_name];
}

