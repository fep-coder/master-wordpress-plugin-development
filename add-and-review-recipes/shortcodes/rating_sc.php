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

        <p><?php echo round($avg_rating); ?></p>

        <?php

        return ob_get_clean();

    }

}
