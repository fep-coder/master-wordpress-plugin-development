<?php

if (!defined('ABSPATH')) {
    exit;
}

class VKF_List_Recipes
{
    public function __construct()
    {
        add_shortcode('list_recipes', [$this, 'list_recipes_shortcode']);
    }

    public function list_recipes_shortcode()
    {
        $args = [
            'post_type' => 'recipe',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        $output = '';

        if ($query->have_posts()) {

            $output .= '<div class="row">';

            while ($query->have_posts()) {
                $query->the_post();

                $thumbnail = get_the_post_thumbnail(
                    get_the_ID(),
                    'medium',
                    ['class' => 'img-fluid', 'alt' => get_the_title()]);

                $output .= '<div class="col-6 pb-5">';

                $output .= '
                <h2> <a class="text-warning" href="' . get_permalink() . '">'
                . get_the_title() . '</a></h2>';

                $output .= do_shortcode('[recipe_rating]');

                if (has_post_thumbnail()) {
                    $output .= '<a href="' . get_permalink() . '">' . $thumbnail . '</a>';
                }

                $output .= '</div>';
            }

            $output .= '</div>';
            wp_reset_postdata();

        } else {
            $output = '<p class="text-center w-100">No recipes found</p>';
        }

        return $output;
    }
}
