<?php

if (!defined('ABSPATH')) {
    exit;
}

class VKF_Front_Filter
{

    public function __construct()
    {
        add_shortcode('vk_filter', [$this, 'front_filter']);
    }

    public function front_filter()
    {
        $categories = get_option('vkf_categories');

        $meals = get_field_object('field_66e3f412c7064');
        $difficulties = get_field_object('field_66e3f4f8c7065');

        ob_start();
        ?>

        <form id="custom-filter-form">
            <h3>Categories</h3>
            <?php if ($categories): ?>
                <div class="mb-3">
                <?php foreach ($categories as $category): ?>
                    <input
                        class="btn-check"
                        type="checkbox"
                        name="categories[]"
                        id="<?php echo esc_attr($category); ?>"
                        value="<?php echo esc_attr($category); ?>"
                    >
                    <label
                        class="btn btn-outline-primary"
                        for="<?php echo esc_attr($category); ?>">
                            <?php echo esc_html($category); ?>
                    </label>
                <?php endforeach;?>
                </div>
            <?php endif;?>

            <h3>Meal</h3>
            <?php if ($meals && $meals['choices']): ?>
                <div class="mb-3">
                <select name="meal" class="form-control">
                <option value="Any">Any</option>
                <?php foreach ($meals['choices'] as $meal): ?>
                    <option value="<?php echo esc_attr($meal); ?>">
                        <?php echo esc_html($meal); ?>
                    </option>
                <?php endforeach;?>
                </select>
                </div>
            <?php endif;?>

            <h3>Difficulty</h3>
            <?php if ($difficulties && $difficulties['choices']): ?>
                <div class="mb-3">
                <?php foreach ($difficulties['choices'] as $difficulty): ?>
                    <input
                        class="btn-check"
                        type="checkbox"
                        name="difficulty[]"
                        id="<?php echo esc_attr($difficulty); ?>"
                        value="<?php echo esc_attr($difficulty); ?>"
                    >
                    <label
                        class="btn btn-outline-primary"
                        for="<?php echo esc_attr($difficulty); ?>">
                            <?php echo esc_html($difficulty); ?>
                    </label>
                <?php endforeach;?>
                </div>
            <?php endif;?>

            <button class="btn btn-primary">Filter</button>
        </form>

        <script>
            jQuery(function ($) {
               $('#custom-filter-form').submit(function(e) {
                    e.preventDefault();

                    const formData = $(this).serialize();

                    $('.bg').addClass('show');

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: formData +'&action=filter_posts',
                        success: function (response) {
                            $('div.recipes').html(response);
                        },
                        complete: function() {
                            $('.bg').removeClass('show');
                        }
                    })
               });
            });
        </script>

        <?php

        return ob_get_clean();
    }
}
