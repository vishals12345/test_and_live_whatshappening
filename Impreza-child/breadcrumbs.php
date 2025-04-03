<?php

function navxt_breadcrumbs() {
  $breadC = '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
      if(function_exists('bcn_display'))
      {
          $breadC .= bcn_display();
      }
  $breadC .= '</div>';
  return $breadC;
}
