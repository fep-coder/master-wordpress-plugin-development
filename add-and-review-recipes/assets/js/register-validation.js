jQuery(document).ready(function ($) {
    $("#register-form").validate({
        rules: {
            username: {
                required: true,
                minlength: 3,
            },
            email: {
                required: true,
                email: true,
                minlength: 6,
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
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address",
                minlength:
                    "Your email address must be at least 6 characters long",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 4 characters long",
            },
        },
    });
});
