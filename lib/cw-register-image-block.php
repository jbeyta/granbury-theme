<?php

function cw_register_respimg_block(){
    wp_register_script('responsive-image', get_template_directory_uri() . '/dist/respimgblock.js', array(
        'wp-element', 'wp-editor', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-server-side-render'
    ));

    register_block_type(
        'cw-blocks/responsive-image',
        array(
            'attributes' => array(
                'imgW' => array(
                    'type' => 'number',
                    'default' => 1600,
                ),
                'imgH' => array(
                    'type' => 'number',
                    'default' => 1200,
                ),
                'imgWMed' => array(
                    'type' => 'number',
                    'default' => 800,
                ),
                'imgHMed' => array(
                    'type' => 'number',
                    'default' => 600,
                ),
                'imgWSmall' => array(
                    'type' => 'number',
                    'default' => 400,
                ),
                'imgHSmall' => array(
                    'type' => 'number',
                    'default' => 300,
                ),
                'crop' => array(
                    'type' => 'boolean',
                    'default' => false,
                ),
                'linkURL' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'targetBlank' => array(
                    'type' => 'boolean',
                    'default' => false
                ),
                // 'pos' => array(
                //     'type' => 'string',
                //     'default' => ''
                // ),
                'imgID' => array(
                    'type' => 'number',
                    'default' => 0
                ),
            ),
            'render_callback' => 'cw_respimg_renderer',
            'editor_script' => 'responsive-image'
        )
    );
}

function cw_respimg_renderer($block_attributes, $content){
    $html = '';

    $is_admin = false;
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        $is_admin = true;
    } else {
        $is_admin = false;
    };

    // need the image id to build custom srcset
    if($block_attributes['imgID']) {

        // build size option data for image script
        $respimg_sizes = array();
    

        if($block_attributes['imgWSmall'] || $block_attributes['imgHSmall']) {
            $respimg_sizes['respimg_size_small'] = array(
                // 'screensize' => 768,
                'w' => $block_attributes['imgWSmall'] ? $block_attributes['imgWSmall'] : NULL,
                'h' => $block_attributes['imgHSmall'] ? $block_attributes['imgHSmall'] : NULL,
                'crop' => $block_attributes['crop'] ? true : false,
            );
        }

        if($block_attributes['imgWMed'] || $block_attributes['imgHMed']) {
            $respimg_sizes['respimg_size_med'] = array(
                // 'screensize' => 1024,
                'w' => $block_attributes['imgWMed'] ? $block_attributes['imgWMed'] : NULL,
                'h' => $block_attributes['imgHMed'] ? $block_attributes['imgHMed'] : NULL,
                'crop' => $block_attributes['crop'] ? true : false,
            );
        }

        if($block_attributes['imgW'] || $block_attributes['imgH']) {
            $respimg_sizes['respimg_size_large'] = array(
                // 'screensize' => 1200,
                'w' => $block_attributes['imgW'] ? $block_attributes['imgW'] : NULL,
                'h' => $block_attributes['imgH'] ? $block_attributes['imgH'] : NULL,
                'crop' => $block_attributes['crop'] ? true : false,
            );
        }

        $resp_image = get_cw_img($block_attributes['imgID'], 'respimg_size_large', $respimg_sizes, '', true);
        // $resp_image .= '<pre>'.print_r($respimg_sizes, true).'</pre>';
    
        // build image link
        $link_start = '';
        $link_end = '';
    
        if($block_attributes['linkURL'] && !$is_admin) {
            $link_start = $block_attributes['targetBlank'] ? '<a href="'.$block_attributes['linkURL'].'" target="_blank">' : '<a href="'.$block_attributes['linkURL'].'">';
            $link_end = '</a>';
        }
    
        $html .= '<div class="cw-resp-img-mother">'.$link_start.$resp_image.$link_end.'</div>';
    }

    return $html;
}

add_action('init', 'cw_register_respimg_block');