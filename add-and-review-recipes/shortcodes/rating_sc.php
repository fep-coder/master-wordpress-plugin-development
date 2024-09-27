<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Rating_SC
{

    public function __construct()
    {
        add_shortcode('recipe_rating', [$this, 'render_rating']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_rating_script']);
    }

    public function render_rating()
    {
        global $wpdb;

        $post_id = get_the_ID();

        // Fetch average rating
        $avg_rating = $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(rating)
            FROM {$wpdb->prefix}aarr_ratings WHERE recipe_id = %d", $post_id
        ));

        $avg_rating = $avg_rating !== null ? $avg_rating : 0;

        ob_start();
        ?>

        <div class="recipe-rating" data-recipe-id="<?php echo $post_id; ?>">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" data-value="<?php echo $i; ?>">
                    <?php echo ($i <= round($avg_rating) ? '&#9733;' : '&#9734;') ?>
                </span>
            <?php endfor;?>
        </div>

        <?php

        return ob_get_clean();

    }

    public function enqueue_rating_script()
    {
        if (is_singular('recipe')) {

            wp_enqueue_script(
                'aarr-rating-script',
                AARR_URL . 'assets/js/rating.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_localize_script('aarr-rating-script', 'aarrRating', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('rating_nonce'),
            ]);

        }

    }

}
