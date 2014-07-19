<?php
/*
[partner name]
*/
function npm_partner_shortcode($atts) {
  if(!is_array($atts)) {
    $atts = [];
  }

  $partner = $atts[0];

  if(empty($partner)) {
    return "";
  }

  $html = eval(file_get_contents(join(DIRECTORY_SEPARATOR, array(NPM_DIR, "partners", "$partner.html"))));

  return "<div class='partner $partner'>$html</span>";
}

add_shortcode('partner', 'npm_partner_shortcode');
?>
