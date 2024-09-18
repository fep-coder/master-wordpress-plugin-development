jQuery(document).ready(function ($) {
    $("#login-form").validate({
        rules: {
            username: {
                required: true,
                minlength: 3,
            },
            password: {
                required: true,
                minlength: 4,
            },
        },
        messages: {
            username: {
                required: "Please enter a username",
                minlength: "Your username must be at least 3 characters long",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 4 characters long",
            },
        },
    });
});
