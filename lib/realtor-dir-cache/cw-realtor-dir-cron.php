<?php
require get_template_directory() . '/lib/realtor-dir-cache/cw-realtor-dir-cache.php';

add_action('cw_realtor_dir_cache', 'cw_realtor_dir_cache_run');

function cw_realtor_dir_cache_run() {
    $cwRealtorCache = new RealtorCache();
    $cwRealtorCache->build_directory();
}

if ( ! wp_next_scheduled( 'cw_realtor_dir_cache' ) ) {
    wp_schedule_event( current_time('timestamp'), 'hourly', 'cw_realtor_dir_cache' );
}