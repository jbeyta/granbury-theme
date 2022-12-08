<?php
    require(get_stylesheet_directory().'/lib/cw-aff-meta.php');
?>

<div class="affiliate">
    <?php
        // $photo_url = get_post_meta($post->ID, '_cwmb_photo_url', true);
        $logo_url = get_post_meta($post->ID, '_cwmb_logo_url', true);
        $affiliate_people = get_post_meta($post->ID, '_cwmb_affiliate_people', true);
        
        // if($photo_url) {
        //     echo '<div class="img-mother">';
        //         echo '<img src="'.$photo_url.'" alt="" />';
        //     echo '</div>';
        // }

        if(is_singular('affiliates')) {
            echo '<h2 class="page-title">'.get_the_title().'</h2>';
            if($post->post_content) {
                echo '<div class="desc">';
                    the_content();
                echo '</div>';
            }
            if($logo_url) {
                echo '<div class="img-mother">';
                    echo '<img src="'.$logo_url.'" alt="" />';
                echo '</div>';
            }
        } else {
            if($logo_url) {
                echo '<div class="img-mother">';
                    echo '<img src="'.$logo_url.'" alt="" />';
                echo '</div>';
            }

            echo '<h4 class="aff-title">'.get_the_title().'</h4>';

            if($post->post_content) {
                echo '<p class="readmore"><a href="'.get_the_permalink().'">Read More</a></p>';
            }
        }

        $contact_first_name = get_post_meta($post->ID, '_cwmb_contact_first_name', true);
        $contact_last_name = get_post_meta($post->ID, '_cwmb_contact_last_name', true);

        if($contact_first_name || $contact_last_name) {

            echo '<p class="poc"><b>Contact:</b> '.$contact_first_name.' '.$contact_last_name.'</p>';
        }

        $work_address_line_one = get_post_meta($post->ID, '_cwmb_work_address_line_one', true);
        $work_address_line_two = get_post_meta($post->ID, '_cwmb_work_address_line_two', true);
        $work_address_line_three = get_post_meta($post->ID, '_cwmb_work_address_line_three', true);
        $work_address_line_four = get_post_meta($post->ID, '_cwmb_work_address_line_four', true);
        // $work_address_district = get_post_meta($post->ID, '_cwmb_work_address_district', true);
        // $work_address_county = get_post_meta($post->ID, '_cwmb_work_address_county', true);
        $work_address_city = get_post_meta($post->ID, '_cwmb_work_address_city', true);
        $work_address_state = get_post_meta($post->ID, '_cwmb_work_address_state', true);
        $work_address_zipcode = get_post_meta($post->ID, '_cwmb_work_address_zipcode', true);
        // $work_address_country = get_post_meta($post->ID, '_cwmb_work_address_country', true);

        $address = '';
		if(!empty($work_address_line_one)) { $address .= $work_address_line_one; }
        if(!empty($work_address_line_two)) { $address .= '<br>'.$work_address_line_two; }
        if(!empty($work_address_line_three)) { $address .= '<br>'.$work_address_line_three; }
        if(!empty($work_address_line_four)) { $address .= '<br>'.$work_address_line_four; }
		if(!empty($work_address_city)) { $address .= '<br>'.$work_address_city; }
		if(!empty($work_address_state) && !empty($work_address_city)) { $address .= ',';}
		if(!empty($work_address_state)) { $address .= ' '.$work_address_state; }
        if(!empty($work_address_zipcode)) { $address .= ' '.$work_address_zipcode; }
        
        if($address) {
            echo '<p class="address">'.$address.'</p>';
        }

        $phone_cell_phone_number = get_post_meta($post->ID, '_cwmb_phone_cell_phone_number', true);
        $phone_work_phone_number = get_post_meta($post->ID, '_cwmb_phone_work_phone_number', true);

        if($phone_cell_phone_number) {
            $phone_cell_phone_number_clean = preg_replace('/[^0-9]/', '', $phone_cell_phone_number);
            echo '<p class="phone"><b>Cell:</b> <a href="tel:'.$phone_cell_phone_number_clean.'">'.$phone_cell_phone_number.'</a></p>';
        }
        if($phone_work_phone_number) {
            $phone_work_phone_number_clean = preg_replace('/[^0-9]/', '', $phone_work_phone_number);
            echo '<p class="phone"><b>Office:</b> <a href="tel:'.$phone_work_phone_number_clean.'">'.$phone_work_phone_number.'</a></p>';
        }

        $phone_work_fax_number = get_post_meta($post->ID, '_cwmb_phone_work_fax_number', true);
        if($phone_work_fax_number) {
            echo '<p class="phone"><b>Fax:</b> '.$phone_work_fax_number.'</p>';
        }

        $email_personal_email_address = get_post_meta($post->ID, '_cwmb_email_personal_email_address', true);
        $email_work_email_address = get_post_meta($post->ID, '_cwmb_email_work_email_address', true);

        if($email_personal_email_address){
            echo '<p class="email"><b>Email:</b> <a href="mailto:'.$email_personal_email_address.'">'.$email_personal_email_address.'</a></p>';
        }
        if($email_work_email_address){
            echo '<p class="email"><b>Email:</b> <a href="mailto:'.$email_work_email_address.'">'.$email_work_email_address.'</a></p>';
        }

        $link_website_url = get_post_meta($post->ID, '_cwmb_link_website_url', true);
        $link_website_title = get_post_meta($post->ID, '_cwmb_link_website_title', true);

        if($link_website_url) {
            if(!$link_website_title || $link_website_title == $link_website_url) {
                $link_website_title = 'Website';
            }
            echo '<p class="website"><a href="'.$link_website_url.'">'.$link_website_title.'</a></p>';
        }

        $socs = array(
            'social_network_facebook_url' => get_post_meta($post->ID, '_cwmb_social_network_facebook_url', true),
            'social_network_linkedin_url' => get_post_meta($post->ID, '_cwmb_social_network_linkedin_url', true),
            'social_network_twitter_url' => get_post_meta($post->ID, '_cwmb_social_network_twitter_url', true),
        );

        echo '<p class="socials">';
            foreach ($socs as $soc) {
				echo '<a class="social-icon" href="'.$soc.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($soc);
				echo '</a>';
            }
        echo '</p>';

        if($affiliate_people) {
            echo '<div class="people">';
                foreach ($affiliate_people as $person) {
                    echo '<div class="person">';
                        echo $person['name'] ? '<h5 class="name">'.$person['name'].'</h5>' : '';
                        echo $person['title'] ? '<h6 class="titl">'.$person['title'].'</h6>' : '';
                        echo $person['phone'] ? '<p><a href="tel:'.$person['phone'].'">'.$person['phone'].'</a></p>' : '';
                        echo $person['email'] ? '<p><a href="mailto:'.$person['email'].'">'.$person['email'].'</a></p>' : '';
                    echo '</div>';
                }
            echo '</div>';
        }
    ?>
</div>