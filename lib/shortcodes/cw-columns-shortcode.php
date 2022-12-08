<?php
// columns
function cw_column( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'size' => '6',
		'screen' => 'm',
		'divider' => ''
	), $atts));

	$class = '';
	if(!empty($divider)) {
		$class = 'divider-'.$divider;
	}

	// clean up the content to remove extra <br> and <p></p> tags
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
	
	return '<div class="'.$screen.''.$size.' '.$class.'">'.$content.'</div>';
}
add_shortcode( 'cw_column', 'cw_column' );

function cw_columns( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'number' => '2'
	), $atts));

	return '<div class="cw-columns-'.$number.'">'.$content.'</div>';
}
add_shortcode( 'cw_columns', 'cw_columns' );