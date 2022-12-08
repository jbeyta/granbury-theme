<?php
/**
 * Template Name: Front-End Realtors Directory (OLD)
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header();?>

<main id="main-content" role="main">
    <div class="row">
        <div class="s12">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php
                while(have_posts()) {
                    the_post();
                    the_content();
                }
            ?>

            <div id="realtor-dir"></div>
        </div>
    </div>
</main>


<?php get_footer(); ?>
