<?php
function get_acf_begin_end_date( $atts ) {

  $field = get_field('begin_date').' - '.get_field('end_date');

  return $field;

}
