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
