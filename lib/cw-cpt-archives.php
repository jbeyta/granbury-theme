<?php
    /**
     * Custom post type specific rewrite rules
     * @return wp_rewrite Rewrite rules handled by WordPress
     */
    function cpt_rewrite_rules($wp_rewrite) {
        // Here we're hardcoding the CPT in, article in this case
        $rules = cpt_generate_date_archives('article', $wp_rewrite);
        $wp_rewrite->rules = $rules + $wp_rewrite->rules;
        return $wp_rewrite;
    }
    add_action('generate_rewrite_rules', 'cpt_rewrite_rules');

    /**
     * Generate date archive rewrite rules for a given custom post type
     * @param  string $cpt slug of the custom post type
     * @return rules       returns a set of rewrite rules for WordPress to handle
     */
    function cpt_generate_date_archives($cpt, $wp_rewrite) {
        $rules = array();

        $post_type = get_post_type_object($cpt);
        $slug_archive = $post_type->has_archive;
        if ($slug_archive === false) {
            return $rules;
        }
        if ($slug_archive === true) {
            // Here's my edit to the original function, let's pick up
            // custom slug from the post type object if user has
            // specified one.
            $slug_archive = $post_type->rewrite['slug'];
        }

        $dates = array(
            array(
                'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
                'vars' => array('year', 'monthnum', 'day')
            ),
            array(
                'rule' => "([0-9]{4})/([0-9]{1,2})",
                'vars' => array('year', 'monthnum')
            ),
            array(
                'rule' => "([0-9]{4})",
                'vars' => array('year')
            )
        );

        foreach ($dates as $data) {
            $query = 'index.php?post_type='.$cpt;
            $rule = $slug_archive.'/'.$data['rule'];

            $i = 1;
            foreach ($data['vars'] as $var) {
                $query.= '&'.$var.'='.$wp_rewrite->preg_index($i);
                $i++;
            }

            $rules[$rule."/?$"] = $query;
            $rules[$rule."/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
            $rules[$rule."/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
            $rules[$rule."/page/([0-9]{1,})/?$"] = $query."&paged=".$wp_rewrite->preg_index($i);
        }
        return $rules;
    }

    function example_getarchives_where($where) {
        return str_replace("WHERE post_type = 'post'", "WHERE post_type IN ('article')", $where);
    }
    add_filter('getarchives_where', 'example_getarchives_where');

    /**
     * Get archives to custom post type
     * @param  string $cpt The wanted custom post type
     * @return array       A list of links to date archives
     */
    function cpt_wp_get_archives($cpt) {
        // Configure the output
        $args = array(
            'format'          => 'custom',
            'before'          => '<li class="post-list__item post-list__item--archive">',
            'after'           => '</li>',
            'echo'            => 0,
            'show_post_count' => true
        );
        // Get the post type objest
        $post_type_obj = get_post_type_object($cpt);
        // Slug might not be the cpt name, it might have custom slug, so get it
        $post_type_slug = $post_type_obj->rewrite['slug'];
        // Domain of the current site
        $host = $_SERVER['HTTP_HOST'];
        // Replace `domain.tld` with `domain.tdl/{cpt-slug}`
        $output = str_replace($host, "$host/$post_type_slug", wp_get_archives($args));

        return $output;
    }