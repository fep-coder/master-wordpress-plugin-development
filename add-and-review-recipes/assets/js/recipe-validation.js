jQuery(document).ready(function ($) {
    $("#add-recipe-form").validate({
        rules: {
            title: {
                required: true,
                minlength: 4,
            },
            category: {
                required: true,
            },
            recipe_image: {
                required: true,
            },
            recipe_content: {
                required: true,
                minlength: 4,
            },
        },
        messages: {
            title: {
                required: "Please enter a title",
                minlength: "Your title must be at least 4 characters long",
            },
            category: {
                required: "Please select a category",
            },
            recipe_image: {
                required: "Please select an image",
            },
            recipe_content: {
                required: "Please enter a recipe",
                minlength: "Your recipe must be at least 4 characters long",
            },
        },
    });
});
