<?php

function google_adsense_vertical_ad() {

  $adsense = '
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7466470214890787"
     crossorigin="anonymous"></script>
  <!-- wh_vertical_ad -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7466470214890787"
       data-ad-slot="3641274645"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
  ';

  return $adsense;

}
