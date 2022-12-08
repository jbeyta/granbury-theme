<?php
// function cw_ajax_get_realtors() {
// 	register_rest_route('cw/v2', '/realtors/', array(
// 		'methods' => 'GET',
// 		'callback' => 'cw_get_realtors'
// 	));
// }
// add_action( 'rest_api_init', 'cw_ajax_get_realtors' );

// function X_cw_get_realtors_X(WP_REST_Request $request) {
//     global $post;
//     $data = array();
//     $data['results'] = array();
//     $data['offices'] = array();

//     if(function_exists('get_offices')) {
//         $limit = 250;
//         $offset = 0;
//         $search_params = array();

//         $offices = get_offices($search_params, $limit, $offset);
//         $upload_dir = wp_upload_dir();
        
//         // additional offices
//         $xoargs = array(
//             'post_type' => 'cwextraoffices',
//             'posts_per_page' =>  -1,
//         );

//         $xoposts = new WP_Query($xoargs);
        
//         if($xoposts->have_posts()) {
//             global $post;
//             while($xoposts->have_posts()) {
//                 $xoposts->the_post();

//                 $mlsid = get_post_meta($post->ID, '_cwmb_mlsid', true);

//                 if(empty($mlsid)) {
//                     $mlsid = $post->ID;
//                 }

//                 array_push($offices, array(
//                     'officeemail' => get_post_meta($post->ID, '_cwmb_email', true),
//                     'officefax' => get_post_meta($post->ID, '_cwmb_fax', true),
//                     'officemailaddress1' => get_post_meta($post->ID, '_cwmb_address1', true),
//                     'officemailcity' => get_post_meta($post->ID, '_cwmb_city', true),
//                     'officemailpostalcode' => get_post_meta($post->ID, '_cwmb_zip', true),
//                     'officemailstateorprovince' => get_post_meta($post->ID, '_cwmb_state', true),
//                     'officemlsid' => $mlsid,
//                     'officename' => $post->post_title,
//                     'officestatus' => 'Active',
//                     'officetype' => 'Regular',
//                     'officeotherphone' => get_post_meta($post->ID, '_cwmb_phone2', true),
//                     'officephone' => get_post_meta($post->ID, '_cwmb_phone', true),
//                     'socialmediawebsiteurlorid' => get_post_meta($post->ID, '_cwmb_website', true),
//                     'photo' => get_post_meta($post->ID, '_cwmb_photo', true),
//                     'socialmediafacebookurlorid' => get_post_meta($post->ID, '_cwmb_facebook', true),
//                     'instagram' => get_post_meta($post->ID, '_cwmb_instagram', true),
//                     'socialmedialinkedinurlorid' => get_post_meta($post->ID, '_cwmb_linkedin', true),
//                     'socialmediatwitterurlorid' => get_post_meta($post->ID, '_cwmb_twitter', true),
//                     'agents' => array(),
//                 ));
//             }
//         }
//         wp_reset_query();

//         $sort_offices = array_column($offices, 'officename');
//         array_multisort($sort_offices, SORT_ASC, SORT_NATURAL|SORT_FLAG_CASE, $offices);

//         if($offices) {
//             foreach ($offices as $key => $office) {
// 			    if (
// 			    	trim(strtolower($office['officename'])) != 'non-mls listing'
// 			    	&& trim(strtolower($office['officename'])) != 'fnis'
// 			    	&& trim(strtolower($office['officename'])) != 'non-member for sale by owner'
// 			    	&& trim(strtolower($office['officename'])) != 'vendor'
// 			    ) {
//                     // get rets image
// 					if(file_exists( $upload_dir['basedir'] . '/offices/' . $office['officemlsid'] . '.jpg') ) {
// 						$office['image_url'] = trim($upload_dir['baseurl']) . '/offices/' . $office['officemlsid'] . '.jpg';
// 					} else if(file_exists( $upload_dir['basedir'] . '/offices/' . $office['officemlsid'] . '.png') ) {
// 						$office['image_url'] = trim($upload_dir['baseurl']) . '/offices/' . $office['officemlsid'] . '.png';
//                     }

// 					$office_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office['officename']);
//                     $office_slug = strtolower( str_replace(' ', '-', $office_slug) );
//                     $office['slug'] = $office_slug;
//                     $data['offices'][$office_slug] = $office['officename'];

//                     // clean up agents
//                     $agents = array();
//                     $agent_names = '';
//                     $agent_titles = '';
//                     $agent_langs = false;
                    
//                     foreach($office['agents'] as $office_agent) {
// 						if(
//                             $office_agent['mlsmembertype'] == 'Office Staff'
//                             || $office_agent['mlsmembertype'] == 'Office Staff (OS)'
//                             || $office_agent['mlsmembertype'] == 'Unlicensed Personal Asst (PANI)'
//                             || $office_agent['mlsmembertype'] == 'MLS Provider Assoc Staff (ST)'
//                             || $office_agent['mlsmembertype'] == 'Manager Sold Only (MS)'
//                             || $office_agent['mlsmembertype'] == 'Tax Only (TO)'
//                             || $office_agent['mlsmembertype'] == 'Agent Assistant (PA)'
//                             || $office_agent['mlsmembertype'] == 'Agent Solds Only (AS)'
//                             || $office_agent['mlsmembertype'] == 'Inactive Type (IA)'
//                         ) {
// 							continue;
// 						}

//                         // if cell and direct work are the same, assume cell - per Colt 4-29-20
//                         if($office_agent['memberdirectphone'] == $office_agent['cellphone']) {
//                             unset($office_agent['memberdirectphone']);
//                         }

//                         $office_agent['memberaor'] = $office['officename'];
//                         $office_agent['office_slug'] = $office['slug'];
//                         $office_agent['searchable'] = strtolower($office_agent['memberfirstname'].' '.$office_agent['memberlastname']);
                        
//                         $agent_names .= ' '.$office_agent['memberfirstname'].' '.$office_agent['memberlastname'];
                        
// 						$agent_name_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office_agent['memberfirstname'].'-'.$office_agent['memberlastname']);
// 						$agent_name_slug = strtolower( str_replace(' ', '-', $agent_name_slug) );

//                         $agent_slug = $agent_name_slug.'_'.$office_slug;
//                         $office_agent['agent_slug'] = $agent_slug;

//                         $clean_agent = array();
//                         $include_keys = array(
//                             'membermobilephone',
//                             'memberemail',
//                             'memberfirstname',
//                             'memberfullname',
//                             'memberlastname',
//                             'memberaor',
//                             'office_slug',
//                             'searchable',
//                             'memberdirectphone',
//                             'agent_slug',
//                         );

//                         foreach ($office_agent as $key => $value) {
//                             if($value && in_array($key, $include_keys)) {
//                                 $clean_agent[$key] = $value;
//                             }
//                         }

//                         // get additional meta
//                         $xmargs = array(
//                             'post_type' => 'cwrealtorinfos',
//                             'posts_per_page' =>  1,
//                             'meta_query' => array(
//                                 array(
//                                     'key' => '_cwmb_cwrealtor',
//                                     'value' => $agent_slug,
//                                     'compare' => '='
//                                 )
//                             )
//                         );
//                         $xmposts = new WP_Query($xmargs);
//                         if($xmposts->have_posts()) {
//                             global $post;
//                             while($xmposts->have_posts()) {
//                                 $xmposts->the_post();

//                                 $bio_content = get_post_meta($post->ID, '_cwmb_bio', true);
//                                 $bio = apply_filters('the_content', $bio_content);
//                                 $langs_content = '';
                                
//                                 $langs = get_post_meta($post->ID, '_cwmb_lang', true);
//                                 if($langs) {
//                                     $langs_content .= '<p><b>Languages Spoken:</b> ';
//                                     foreach ($langs as $key => $lang) {
//                                         if($key) {
//                                             $langs_content .= ', '.$lang;
//                                         } else {
//                                             $langs_content .= $lang;
//                                         }
//                                     }
//                                     $langs_content .= '</p>';

//                                     $agent_langs = true;
//                                 }

//                                 $aTitle = get_post_meta($post->ID, '_cwmb_title', true);

//                                 $agent_titles .= ' '.$aTitle;

//                                 $clean_agent['langs'] = $langs_content;
//                                 $clean_agent['photo'] = get_post_meta($post->ID, '_cwmb_photo', true);
//                                 $clean_agent['title'] = $aTitle;
//                                 $clean_agent['socialmediawebsiteurlorid'] = get_post_meta($post->ID, '_cwmb_website', true);
//                                 $clean_agent['socialmediafacebookurlorid'] = get_post_meta($post->ID, '_cwmb_facebook', true);
//                                 $clean_agent['instagram'] = get_post_meta($post->ID, '_cwmb_instagram', true);
//                                 $clean_agent['socialmedialinkedinurlorid'] = get_post_meta($post->ID, '_cwmb_linkedin', true);
//                                 $clean_agent['socialmediawebsiteurlorid'] = get_post_meta($post->ID, '_cwmb_twitter', true);
//                                 $clean_agent['bio'] = $bio;
//                             }
//                         }
//                         wp_reset_query();

//                         array_push($agents, $clean_agent);
//                     }
                    
//                     // additional agents
//                     $xaargs = array(
//                         'post_type' => 'cwextrarealtors',
//                         'posts_per_page' =>  -1,
//                         'meta_query' => array(
//                             array(
//                                 'key' => '_cwmb_cwoffice',
//                                 'value' => $office['officemlsid'],
//                                 'compage' => 'LIKE'
//                             )
//                         )
//                     );
//                     $xaposts = new WP_Query($xaargs);
//                     if($xaposts->have_posts()) {
//                         global $post;
//                         while($xaposts->have_posts()) {
//                             $xaposts->the_post();
//                             $firstname = get_post_meta($post->ID, '_cwmb_first_name', true);
//                             $lastname = get_post_meta($post->ID, '_cwmb_last_name', true);
                            
//                             if($firstname && $lastname) {
//                                 $fullname = get_post_meta($post->ID, '_cwmb_full_name', true);
//                                 $title = get_post_meta($post->ID, '_cwmb_title', true);
//                                 $agent_titles .= ' '.$title;
//                                 $photo = get_post_meta($post->ID, '_cwmb_photo', true);
//                                 $email = get_post_meta($post->ID, '_cwmb_email', true);
//                                 $website = get_post_meta($post->ID, '_cwmb_website', true);
//                                 $facebook = get_post_meta($post->ID, '_cwmb_facebook', true);
//                                 $instagram = get_post_meta($post->ID, '_cwmb_instagram', true);
//                                 $linkedin = get_post_meta($post->ID, '_cwmb_linkedin', true);
//                                 $twitter = get_post_meta($post->ID, '_cwmb_twitter', true);
//                                 $cellphone = get_post_meta($post->ID, '_cwmb_cellphone', true);
//                                 $bio = get_post_meta($post->ID, '_cwmb_bio', true);

//                                 $agent_names .= ' '.$firstname.' '.$lastname;
    
//                                 array_push($agents, array(
//                                     'memberfirstname' => $firstname,
//                                     'memberlastname' => $lastname,
//                                     'memberfullname' => $fullname,
//                                     'title' => $title,
//                                     'photo' => $photo,
//                                     'memberemail' => $email,
//                                     'socialmediawebsiteurlorid' => $website,
//                                     'socialmediafacebookurlorid' => $facebook,
//                                     'instagram' => $instagram,
//                                     'socialmedialinkedinurlorid' => $linkedin,
//                                     'socialmediatwitterurlorid' => $twitter,
//                                     'membermobilephone' => $cellphone,
//                                     'bio' => apply_filters('the_content', $bio),
//                                     'office_slug' => sanitize_title($office['officename']),
//                                     'searchable' => strtolower($firstname.' '.$lastname),
//                                     'agent_slug' => $post->post_name,
//                                     'office_name' => $office['officename'],
//                                 ));

                                
                                
//                             }
//                         }
//                     }
//                     wp_reset_query();

//                     // sort by last name
//                     $sort_agents = array_column($agents, 'lastname');

//                     if(count($sort_agents) == count($agents)) {
//                         array_multisort($sort_agents, SORT_ASC, $agents);
//                     }

//                     $office['agents'] = $agents;
//                     $office['agent_names'] = strtolower($agent_names);
//                     $office['agent_titles'] = strtolower($agent_titles);
//                     $office['agent_langs'] = strtolower($agent_langs);

//                     // get additional meta
//                     $xomargs = array(
//                         'post_type' => 'cwofficeinfos',
//                         'posts_per_page' =>  1,
//                         'meta_query' => array(
//                             array(
//                                 'key' => '_cwmb_cwoffice',
//                                 'value' => $office['officemlsid'],
//                                 'compare' => '='
//                             )
//                         )
//                     );
//                     $xomposts = new WP_Query($xomargs);
//                     if($xomposts->have_posts()) {
//                         global $post;
//                         while($xomposts->have_posts()) {
//                             $xomposts->the_post();
//                             $office['photo'] = get_post_meta($post->ID, '_cwmb_photo', true);

//                             $office['facebook'] = get_post_meta($post->ID, '_cwmb_facebook', true);
//                             $office['instagram'] = get_post_meta($post->ID, '_cwmb_instagram', true);
//                             $office['linkedin'] = get_post_meta($post->ID, '_cwmb_linkedin', true);
//                             $office['twitter'] = get_post_meta($post->ID, '_cwmb_twitter', true);
//                         }
//                     }
//                     wp_reset_query();

//                     array_push($data['results'], $office);
//                 }
//             }
//         }
//     }
    
// 	return $data;
// 	exit;
// }

function cw_ajax_get_just_realtors() {
	register_rest_route('cw/v2', '/justrealtors/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_just_realtors'
	));
}
add_action( 'rest_api_init', 'cw_ajax_get_just_realtors' );
function cw_get_just_realtors(){
	$realtors = array();
	
    global $wpdb;
    $offices = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rets_offices ORDER BY `office_name`", ARRAY_A );
    if(!empty($offices)) {
        foreach($offices as $office) {
            $officeRealtors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rets_agents WHERE `office_id` LIKE '".$office['office_id']."' ORDER BY `last_name`", ARRAY_A );

            $office_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office['office_name']);
            $office_slug = strtolower( str_replace(' ', '-', $office_slug) );

            if($officeRealtors) {
                foreach ($officeRealtors as $office_agent) {
                    if(
                        $office_agent['member_mls_type'] == 'Office Staff'
                        || $office_agent['member_mls_type'] == 'Office Staff (OS)'
                        || $office_agent['member_mls_type'] == 'MLS Provider Assoc Staff (ST)'
                        || $office_agent['member_mls_type'] == 'Manager Sold Only (MS)'
                        || $office_agent['member_mls_type'] == 'Tax Only (TO)'
                        || $office_agent['member_mls_type'] == 'Agent Assistant (PA)'
                        || $office_agent['member_mls_type'] == 'Agent Solds Only (AS)'
                        || $office_agent['member_mls_type'] == 'Inactive Type (IA)'
                    ) {
                        continue;
                    }

                    $agent_name_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office_agent['first_name'].'-'.$office_agent['last_name']);
                    $agent_name_slug = strtolower( str_replace(' ', '-', $agent_name_slug) );

                    $agent_slug = $agent_name_slug.'_'.$office_slug;

                    $existing_post = '';
                    $riargs = array(
                        'post_type' => 'cwrealtorinfos',
                        'posts_per_page' =>  -1,
                        'meta_query' => array(
                            array(
                                'key' => '_cwmb_cwrealtor',
                                'value' => $agent_slug,
                                'compare' => '='
                            )
                        )
                    );
                    $riposts = new WP_Query($riargs);
                    if($riposts->have_posts()) {
                        global $post;
                        while($riposts->have_posts()) {
                            $riposts->the_post();
                            $existing_post = $post->ID;
                        }
                    }
                    wp_reset_query();

                    $rd = [];
                    $rd['slug'] = $agent_slug;
                    $rd['name'] = $office_agent['first_name'].' '.$office_agent['last_name'].' - '.$office['office_name'];
                    $rd['first_name'] = $office_agent['first_name'];
                    $rd['last_name'] = $office_agent['last_name'];
                    $rd['office_name'] = $office['office_name'];
                    $rd['existing_post'] = $existing_post;
                    
                    array_push($realtors, $rd);
                }
            }
        }
    }

    return $realtors;
    exit;
}

// offices
function cw_ajax_get_just_offices() {
	register_rest_route('cw/v2', '/justoffices/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_just_offices'
	));
}
add_action( 'rest_api_init', 'cw_ajax_get_just_offices' );
function cw_get_just_offices(){
	$results = array();
	
    global $wpdb;
    $offices = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rets_offices ORDER BY `office_name`", ARRAY_A );

    if($offices) {
        // echo_pre($offices);
        foreach ($offices as $key => $office) {
            $od = [];

            $office_slug = sanitize_title($office['office_name']);

            $od['slug'] = $office_slug;
            $od['name'] = $office['office_name'];
            $od['officemlsid'] = $office['member_id'];

            if(!in_array($od, $results)) {
                array_push($results, $od);
            }
        }
    }

    // additional offices
    $xoargs = array(
        'post_type' => 'cwextraoffices',
        'posts_per_page' =>  -1,
    );
    $xoposts = new WP_Query($xoargs);
    if($xoposts->have_posts()) {
        global $post;
        while($xoposts->have_posts()) {
            $xoposts->the_post();

            $mlsid = get_post_meta($post->ID, '_cwmb_mlsid', true);

            if(empty($mlsid)) {
                $mlsid = $post->ID;
            }

            array_push($results, array(
                'slug' => $post->post_name,
                'name' => $post->post_title,
                'officemlsid' => $mlsid,
            ));
        }
    }
    wp_reset_query();

    $sort_offices = array_column($results, 'name');
    array_multisort($sort_offices, SORT_ASC, SORT_NATURAL|SORT_FLAG_CASE, $results);

    return $results;
    exit;
}

//_________________________________ importer _________________________________//
// function cw_ajax_get_agents_csv() {
// 	register_rest_route('cw/v2', '/csvagents/', array(
// 		'methods' => 'GET',
// 		'callback' => 'cw_get_csvagents'
// 	));
// }
// add_action( 'rest_api_init', 'cw_ajax_get_agents_csv' );
// function cw_get_csvagents(){
// 	$results = array();
	
//     $filename = 'cn-export-all-05-06-2020.csv';
//     $realts = []; 

//     if (($h = fopen("{$filename}", "r")) !== FALSE) {
//         while (($data = fgetcsv($h, 9999, ",")) !== FALSE) {
//             $realts[] = $data;		
//         }
//         fclose($h);
//     }

//     $meta_keys = array(
//         'entry_id',
//         'order',
//         'entry_type',
//         'visibility',
//         'categories',
//         'family_name',
//         'honorific_prefix',
//         'first_name',
//         'middle_name',
//         'last_name',
//         'honorific_suffix',
//         'title',
//         'organization',
//         'department',
//         'contact_first_name',
//         'contact_last_name',
//         'home_address_line_one',
//         'home_address_line_two',
//         'home_address_line_three',
//         'home_address_line_four',
//         'home_address_district',
//         'home_address_county',
//         'home_address_city',
//         'home_address_state',
//         'home_address_zipcode',
//         'home_address_country',
//         'home_address_latitude',
//         'home_address_longitude',
//         'home_address_visibility',
//         'work_address_line_one',
//         'work_address_line_two',
//         'work_address_line_three',
//         'work_address_line_four',
//         'work_address_district',
//         'work_address_county',
//         'work_address_city',
//         'work_address_state',
//         'work_address_zipcode',
//         'work_address_country',
//         'work_address_latitude',
//         'work_address_longitude',
//         'work_address_visibility',
//         'phone_cell_phone_number',
//         'phone_cell_phone_visibility',
//         'phone_home_phone_number',
//         'phone_home_phone_visibility',
//         'phone_work_fax_number',
//         'phone_work_fax_visibility',
//         'phone_work_phone_number',
//         'phone_work_phone_visibility',
//         'email_personal_email_address',
//         'email_personal_email_visibility',
//         'email_work_email_address',
//         'email_work_email_visibility',
//         'social_network_facebook_url',
//         'social_network_facebook_visibility',
//         'social_network_linkedin_url',
//         'social_network_linkedin_visibility',
//         'social_network_twitter_url',
//         'social_network_twitter_visibility',
//         'im_uid',
//         'im_visibility',
//         'link_website_url',
//         'link_website_title',
//         'link_website_visibility',
//         'dates_date',
//         'dates_visibility',
//         'biography',
//         'notes',
//         'photo_url',
//         'logo_url',
//     );

//     $realt_import = array();
//     foreach ($realts as $key => $realt) {
//         if($key > 0) {
//             $realt_data = array();

//             foreach ($realt as $key => $realt_meta) {
//                 if($realt_meta) {
//                     $realt_data[$meta_keys[$key]] = $realt_meta;
//                 }
//             }

//             array_push($realt_import, $realt_data);
//         }
//     }

//     foreach ($realt_import as $realt) {
//         $realt_info = array();
//         $cats = explode(',', $realt['categories']);
//         if(in_array('REALTOR', $cats) || in_array('realtor', $cats)) {
//             $post_title = $realt['first_name'].' '.$realt['last_name'].' - '.$realt['organization'];

//             $agent_name_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $realt['first_name'].'-'.$realt['last_name']);
//             $agent_name_slug = strtolower( str_replace(' ', '-', $agent_name_slug) );

//             $office_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $realt['organization']);
//             $office_slug = strtolower( str_replace(' ', '-', $office_slug) );

//             $agent_slug = $agent_name_slug.'_'.$office_slug;
//             $realt_info['agent_slug'] = $agent_slug;
//             $realt_info['first_name'] = $realt['first_name'];
//             $realt_info['last_name'] = $realt['last_name'];
//             $realt_info['organization'] = $realt['organization'];

//             if($realt['photo_url']) {
//                 $realt_info['photo_url'] = $realt['photo_url'];
//             } else {
//                 $realt_info['photo_url'] = '';
//             }

//             if($realt['title']) {
//                 $realt_info['title'] = $realt['title'];
//             } else {
//                 $realt_info['title'] = '';
//             }

//             if($realt['biography']) {
//                 $realt_info['bio'] = $realt['biography'];
//             } else {
//                 $realt_info['bio'] = '';
//             }

//             if($realt['social_network_facebook_url']) {
//                 $realt_info['facebook'] = $realt['social_network_facebook_url'];
//             } else {
//                 $realt_info['facebook'] = '';
//             }

//             if($realt['social_network_linkedin_url']) {
//                 $realt_info['linkedin'] = $realt['social_network_linkedin_url'];
//             } else {
//                 $realt_info['linkedin'] = '';
//             }

//             if($realt['social_network_twitter_url']) {
//                 $realt_info['twitter'] = $realt['social_network_twitter_url'];
//             } else {
//                 $realt_info['twitter'] = '';
//             }

//             array_push($results, $realt_info);
//         }
//     }

//     return $results;
//     exit;
// }

// function cw_ajax_find_cwrealtorinfos() {
// 	register_rest_route('cw/v2', '/existingcwrealtorinfos/', array(
// 		'methods' => 'GET',
// 		'callback' => 'cw_find_cwrealtorinfos'
// 	));
// }
// add_action( 'rest_api_init', 'cw_ajax_find_cwrealtorinfos' );
// function cw_find_cwrealtorinfos(){
//     $results = array();

//     $riargs = array(
//         'post_type' => 'cwrealtorinfos',
//         'posts_per_page' =>  -1,
//         'meta_query' => array(
//             array(
//                 'key' => '_cwmb_cwrealtor',
//                 'value' => $_GET['agentslug'],
//                 'compare' => '='
//             )
//         )
//     );
//     $riposts = new WP_Query($riargs);
//     if($riposts->have_posts()) {
//         global $post;
//         while($riposts->have_posts()) {
//             $riposts->the_post();
//             array_push($results, $post->ID);
//         }
//     }
//     wp_reset_query();

//     return $results;
//     exit;
// }

// function cw_ajax_addrealtorinfo() {
// 	register_rest_route('cw/v2', '/addrealtorinfo/', array(
// 		'methods' => 'POST',
// 		'callback' => 'cw_get_addrealtorinfo'
// 	));
// }
// add_action( 'rest_api_init', 'cw_ajax_addrealtorinfo' );
// function cw_get_addrealtorinfo(){
//     if(
//         $_POST['bio'] ||
//         $_POST['facebook'] ||
//         $_POST['linkedin'] ||
//         $_POST['twitter'] ||
//         $_POST['title']
//     ){
//         $postData = array(
//             'post_type' => 'cwrealtorinfos',
//             'post_status' => 'publish',
//             'post_title' => $_POST['posttitle'],
//             'post_content' => '',
//         );

//         if($_POST['expostid']) {
//             $postid = $_POST['expostid'];
//             $postData['ID'] = $_POST['expostid'];
//             wp_update_post( $postData );
//         } else {
//             $postid = wp_insert_post($postData);
//         }

//         if($postid) {
//             update_post_meta($postid, '_cwmb_cwrealtor', $_POST['agentslug']);

//             if($_POST['bio']) {
//                 update_post_meta($postid, '_cwmb_bio', $_POST['bio']);
//             }

//             if($_POST['facebook']) {
//                 update_post_meta($postid, '_cwmb_facebook', $_POST['facebook']);
//             }

//             if($_POST['linkedin']) {
//                 update_post_meta($postid, '_cwmb_linkedin', $_POST['linkedin']);
//             }

//             if($_POST['twitter']) {
//                 update_post_meta($postid, '_cwmb_twitter', $_POST['twitter']);
//             }

//             if($_POST['title']) {
//                 update_post_meta($postid, '_cwmb_title', $_POST['title']);
//             }

//             if($_POST['photo_url']) {
//                 update_post_meta($postid, '_cwmb_photo', $_POST['photo_url']);
//             }
//         }
//     }

//     return $_POST;
//     exit;
// }

function cw_manual_import() {
	register_rest_route('cw/v2', '/manual-import/', array(
		'methods' => 'GET',
		'callback' => 'cw_manual_import_run'
	));

}
add_action( 'rest_api_init', 'cw_manual_import' );

function cw_manual_import_run(WP_REST_Request $request) {    
    global $wpdb;
    $debug = true;

    if(class_exists('cwRETS')) {
        $cwRETS = new cwRETS($wpdb->prefix, $debug);
        $cwRETS->cwr_import();
    }

	return;
	exit;
}