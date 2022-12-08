<?php
// block php resources
function cw_cpt_block() {
	register_block_type( 'cw-cpt-selector-block/cpt-selector', array( 'editor_script' => 'cw_admin_js', ) );
}
add_action( 'init', 'cw_cpt_block' );