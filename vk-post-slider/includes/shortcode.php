<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class VKPS_Shortcode
{
    public function __construct()
    {
        add_shortcode('vk_slider', [$this, 'vkps_display_specific_posts']);
    }

    public function vkps_display_specific_posts($atts)
    {

        $atts = shortcode_atts(['ids' => ''], $atts);

        $post_ids =
        !empty($atts['ids'])
        ? explode(',', $atts['ids'])
        : explode(',', get_option('vk_post_ids'));

        $args = [
            'post_type' => 'post',
            'post__in' => $post_ids,
            'orderby' => 'post__in',
        ];
        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            return '<p>No posts found.</p>';
        }

        // Start output buffering
        ob_start();

        echo '<div class="slider">';

        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div>
                <?php the_post_thumbnail();?>
                <h2><?php the_title();?></h2>
                <?php the_content();?>
            </div>

        <?php

        }

        echo '</div>';

        wp_reset_postdata();

        // Get the contents of the output buffer and clean it up
        return ob_get_clean();
    }

}
