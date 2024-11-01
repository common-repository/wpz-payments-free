<?php

defined('ABSPATH') || exit;

/**
 * Get decoded icon character
 *
 * @return String
 *
 */
function DS_Divi_Payment_decoded_et_icon($icon) {
	//return '\\'.str_replace( ';', '', str_replace( '&#x', '', html_entity_decode( et_pb_process_font_icon( $icon ) ) ) );
	return str_replace(';', '', str_replace('&#x', '', html_entity_decode(et_pb_process_font_icon($icon))));
}

