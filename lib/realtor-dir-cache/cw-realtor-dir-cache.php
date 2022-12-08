<?php

class RealtorCache {
    public function build_directory() {
        $data = [];
        $offices = [];
    
        global $wpdb;
    
        $offices_data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rets_offices ORDER BY `office_name`", ARRAY_A );
    
        foreach($offices_data as $ofc) {
            // exclude offices by name
            // if($ofc['office_name'] == '') {
            //     continue;
            // }
    
            $rltrs = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rets_agents WHERE `office_id` LIKE {$ofc['office_id']} ORDER BY `last_name`", ARRAY_A );
    
            $realtors = [];
    
            if($rltrs) {
                $rlt_names = '';
    
                foreach($rltrs as $rlt) {
                    if(
                        $rlt['member_mls_type'] == 'Office Staff'
                        || $rlt['member_mls_type'] == 'Office Staff (OS)'
                        || $rlt['member_mls_type'] == 'Unlicensed Personal Asst (PANI)'
                        || $rlt['member_mls_type'] == 'MLS Provider Assoc Staff (ST)'
                        || $rlt['member_mls_type'] == 'Manager Sold Only (MS)'
                        || $rlt['member_mls_type'] == 'Tax Only (TO)'
                        || $rlt['member_mls_type'] == 'Agent Assistant (PA)'
                        || $rlt['member_mls_type'] == 'Agent Solds Only (AS)'
                        || $rlt['member_mls_type'] == 'Inactive Type (IA)'
                    ) {
                        continue;
                    }

                    $rlt_names .= strtolower($rlt['first_name'].' '.$rlt['last_name'].' ');

                    $upload_dir = wp_upload_dir();
                    $photoPath = $upload_dir['basedir'] . '/rets_images/member-' .$rlt['agent_id']. '-1.jpg';
                    $photoURL = $upload_dir['baseurl'] . '/rets_images/member-' .$rlt['agent_id']. '-1.jpg';

                    if(file_exists($photoPath)) {
                        $rlt['photo'] = $photoURL;
                    } else {
                        $rlt['photo'] = '';
                    }
                    // if(isset($_GET['dev'])){
                    //     echo_pre($rlt);
                    // }
                    array_push($realtors, array_unique($rlt));
                }
            }
    
            $office = array_unique($ofc);
    
            $office['realtornames'] = $rlt_names ? $rlt_names : '';
            $office['realtors'] = $realtors;

            array_push($offices, $office);
        }
            
        // // additional offices
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
    
                array_push($offices, array(
                    'email' => get_post_meta($post->ID, '_cwmb_email', true),
                    'fax' => get_post_meta($post->ID, '_cwmb_fax', true),
                    'address1' => get_post_meta($post->ID, '_cwmb_address1', true),
                    'city' => get_post_meta($post->ID, '_cwmb_city', true),
                    'zip' => get_post_meta($post->ID, '_cwmb_zip', true),
                    'state' => get_post_meta($post->ID, '_cwmb_state', true),
                    'office_id' => $post->ID,
                    'member_id' => $post->ID,
                    'office_name' => $post->post_title,
                    'phone_2_number' => get_post_meta($post->ID, '_cwmb_phone2', true),
                    'phone_1_number' => get_post_meta($post->ID, '_cwmb_phone', true),
                    'photo' => get_post_meta($post->ID, '_cwmb_photo', true),
                    'website' => get_post_meta($post->ID, '_cwmb_website', true),
                    'facebook' => get_post_meta($post->ID, '_cwmb_facebook', true),
                    'instagram' => get_post_meta($post->ID, '_cwmb_instagram', true),
                    'linkedin' => get_post_meta($post->ID, '_cwmb_linkedin', true),
                    'twitter' => get_post_meta($post->ID, '_cwmb_twitter', true),
                    'realtors' => [],
                    'realtornames' => '',
                ));
            }
        }
        wp_reset_query();
    
        $sort_offices = array_column($offices, 'office_name');
        array_multisort($sort_offices, SORT_ASC, SORT_NATURAL|SORT_FLAG_CASE, $offices);
    
        $upload_dir = wp_upload_dir();
    
        if($offices) {
            foreach ($offices as $key => $office) {
                // if (
                //     trim(strtolower($office['officename'])) != 'non-mls listing'
                //     && trim(strtolower($office['officename'])) != 'fnis'
                //     && trim(strtolower($office['officename'])) != 'non-member for sale by owner'
                //     && trim(strtolower($office['officename'])) != 'vendor'
                // ) {
                //     continue;
                // }
    
                // get rets image
                if(file_exists( $upload_dir['basedir'] . '/offices/' . $office['member_id'] . '.jpg') ) {
                    $office['image_url'] = trim($upload_dir['baseurl']) . '/offices/' . $office['member_id'] . '.jpg';
                } else if(file_exists( $upload_dir['basedir'] . '/offices/' . $office['member_id'] . '.png') ) {
                    $office['image_url'] = trim($upload_dir['baseurl']) . '/offices/' . $office['member_id'] . '.png';
                }
    
                $office_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office['office_name']);
                $office_slug = strtolower( str_replace(' ', '-', $office_slug) );
                $office['slug'] = $office_slug;
    
                // clean up agents
                $agents = [];
                $agent_names = '';
                $agent_titles = '';
                $agent_langs = false;
    
                foreach($office['realtors'] as $office_agent) {
                    if(
                        $office_agent['member_mls_provider'] == 'Office Staff'
                        || $office_agent['member_mls_provider'] == 'Office Staff (OS)'
                        || $office_agent['member_mls_provider'] == 'Unlicensed Personal Asst (PANI)'
                        || $office_agent['member_mls_provider'] == 'MLS Provider Assoc Staff (ST)'
                        || $office_agent['member_mls_provider'] == 'Manager Sold Only (MS)'
                        || $office_agent['member_mls_provider'] == 'Tax Only (TO)'
                        || $office_agent['member_mls_provider'] == 'Agent Assistant (PA)'
                        || $office_agent['member_mls_provider'] == 'Agent Solds Only (AS)'
                        || $office_agent['member_mls_provider'] == 'Inactive Type (IA)'
                    ) {
                        continue;
                    }
    
                    // if cell and direct work are the same, assume cell - per Colt 4-29-20
                    if($office_agent['phone_1_number'] == $office_agent['cellphone']) {
                        unset($office_agent['phone_1_number']);
                    }
    
                    $office_agent['member_mls_provider'] = $office['office_name'];
                    $office_agent['office_slug'] = $office['slug'];
                    $office_agent['searchable'] = strtolower($office_agent['first_name'].' '.$office_agent['last_name']);
                    
                    $agent_names .= ' '.$office_agent['first_name'].' '.$office_agent['last_name'];
                    
                    $agent_name_slug = preg_replace("/[^A-Za-z0-9 ]/", '', $office_agent['first_name'].'-'.$office_agent['last_name']);
                    $agent_name_slug = strtolower( str_replace(' ', '-', $agent_name_slug) );
    
                    $agent_slug = $agent_name_slug.'_'.$office_slug;
                    $office_agent['agent_slug'] = $agent_slug;
    
                    $clean_agent = [];
                    // $include_keys = array(
                    //     'phone_2_number',
                    //     'email',
                    //     'first_name',
                    //     'last_name',
                    //     'member_mls_provider',
                    //     'office_slug',
                    //     'phone_1_number',
                    //     'agent_slug',
                    //     'photo'
                    // );
    
                    foreach ($office_agent as $key => $value) {
                        // if($value && in_array($key, $include_keys)) {
                        // }
                        $clean_agent[$key] = $value;
                    }
    
                    // get additional meta
                    $xmargs = array(
                        'post_type' => 'cwrealtorinfos',
                        'posts_per_page' =>  1,
                        'meta_query' => array(
                            array(
                                'key' => '_cwmb_cwrealtor',
                                'value' => $agent_slug,
                                'compare' => '='
                            )
                        )
                    );
                    $xmposts = new WP_Query($xmargs);
                    if($xmposts->have_posts()) {
                        global $post;
                        while($xmposts->have_posts()) {
                            $xmposts->the_post();
    
                            $bio_content = get_post_meta($post->ID, '_cwmb_bio', true);
                            $bio = apply_filters('the_content', $bio_content);
                            $langs_content = '';
                            
                            $langs = get_post_meta($post->ID, '_cwmb_lang', true);
                            if($langs) {
                                $langs_content .= '<p><b>Languages Spoken:</b> ';
                                foreach ($langs as $key => $lang) {
                                    if($key) {
                                        $langs_content .= ', '.$lang;
                                    } else {
                                        $langs_content .= $lang;
                                    }
                                }
                                $langs_content .= '</p>';
    
                                $agent_langs = true;
                            }
    
                            $aTitle = get_post_meta($post->ID, '_cwmb_title', true);
    
                            $agent_titles .= ' '.$aTitle;
    
                            $photo = get_post_meta($post->ID, '_cwmb_photo', true);
                            $website = get_post_meta($post->ID, '_cwmb_website', true);
                            $facebook = get_post_meta($post->ID, '_cwmb_facebook', true);
                            $instagram = get_post_meta($post->ID, '_cwmb_instagram', true);
                            $linkedin = get_post_meta($post->ID, '_cwmb_linkedin', true);
                            $twitter = get_post_meta($post->ID, '_cwmb_twitter', true);

                            $clean_agent['langs'] = $langs_content;

                            if($photo) {
                                $clean_agent['photo'] = $photo;
                            }

                            $clean_agent['title'] = $aTitle;
                            
                            if($website) {
                                $clean_agent['website'] = $website;
                            }

                            if($facebook) {
                                $clean_agent['facebook'] = $facebook;
                            }

                            if($instagram) {
                                $clean_agent['instagram'] = $instagram;
                            }

                            if($linkedin) {
                                $clean_agent['linkedin'] = $linkedin;
                            }

                            if($twitter) {
                                $clean_agent['twitter'] = $twitter;
                            }

                            $clean_agent['bio'] = strip_tags(html_entity_decode($bio));
                        }
                    }
                    wp_reset_query();
    
                    array_push($agents, $clean_agent);
                }

                // additional agents
                $xaargs = array(
                    'post_type' => 'cwextrarealtors',
                    'posts_per_page' =>  -1,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => '_cwmb_cwoffice',
                            'value' => $office['member_id'],
                            'compage' => 'LIKE'
                        )
                    )
                );
                $xaposts = new WP_Query($xaargs);
                if($xaposts->have_posts()) {
                    global $post;
                    while($xaposts->have_posts()) {
                        $xaposts->the_post();
                        $firstname = get_post_meta($post->ID, '_cwmb_first_name', true);
                        $lastname = get_post_meta($post->ID, '_cwmb_last_name', true);
                        
                        if($firstname && $lastname) {
                            $fullname = get_post_meta($post->ID, '_cwmb_full_name', true);
                            if(empty($fullname)) {
                                $fullname = $firstname.' '.$lastname;
                            }
                            $title = get_post_meta($post->ID, '_cwmb_title', true);
                            $agent_titles .= ' '.$title;
                            $photo = get_post_meta($post->ID, '_cwmb_photo', true);
                            $email = get_post_meta($post->ID, '_cwmb_email', true);
                            $website = get_post_meta($post->ID, '_cwmb_website', true);
                            $facebook = get_post_meta($post->ID, '_cwmb_facebook', true);
                            $instagram = get_post_meta($post->ID, '_cwmb_instagram', true);
                            $linkedin = get_post_meta($post->ID, '_cwmb_linkedin', true);
                            $twitter = get_post_meta($post->ID, '_cwmb_twitter', true);
                            $cellphone = get_post_meta($post->ID, '_cwmb_cellphone', true);
                            $bio = get_post_meta($post->ID, '_cwmb_bio', true);
    
                            $agent_names .= ' '.$firstname.' '.$lastname;
    
                            array_push($agents, array(
                                'first_name' => $firstname,
                                'last_name' => $lastname,
                                'memberfullname' => $fullname,
                                'title' => $title,
                                'photo' => $photo,
                                'email' => $email,
                                'website' => $website,
                                'facebook' => $facebook,
                                'instagram' => $instagram,
                                'linkedin' => $linkedin,
                                'twitter' => $twitter,
                                'phone_2_number' => $cellphone,
                                'bio' => strip_tags(html_entity_decode($bio)),
                                'office_slug' => sanitize_title($office['office_name']),
                                'searchable' => strtolower($firstname.' '.$lastname),
                                'agent_slug' => $post->post_name,
                                'office_name' => $office['office_name'],
                            ));
                        }
                    }
                }
                wp_reset_query();
    
                // sort by last name
                $sort_agents = array_column($agents, 'lastname');
    
                if(count($sort_agents) == count($agents)) {
                    array_multisort($sort_agents, SORT_ASC, $agents);
                }
    
                $office['realtors'] = $agents;
                $office['realtornames'] = strtolower($agent_names);
                $office['agent_titles'] = strtolower($agent_titles);
                $office['agent_langs'] = strtolower($agent_langs);
    
                // get additional meta
                $xomargs = array(
                    'post_type' => 'cwofficeinfos',
                    'posts_per_page' =>  1,
                    'meta_query' => array(
                        array(
                            'key' => '_cwmb_cwoffice',
                            'value' => $office['member_id'],
                            'compare' => '='
                        )
                    )
                );
                $xomposts = new WP_Query($xomargs);
                if($xomposts->have_posts()) {
                    global $post;
                    while($xomposts->have_posts()) {
                        $xomposts->the_post();
                        $office['photo'] = get_post_meta($post->ID, '_cwmb_photo', true);
    
                        $office['facebook'] = get_post_meta($post->ID, '_cwmb_facebook', true);
                        $office['instagram'] = get_post_meta($post->ID, '_cwmb_instagram', true);
                        $office['linkedin'] = get_post_meta($post->ID, '_cwmb_linkedin', true);
                        $office['twitter'] = get_post_meta($post->ID, '_cwmb_twitter', true);
                    }
                }
                wp_reset_query();
    
                array_push($data, $office);
            }
        }
        // if(isset($_GET['dev'])){
        //     echo_pre($data);
        // }
        update_option('_realtor_directory_cache', $data);
    }
}