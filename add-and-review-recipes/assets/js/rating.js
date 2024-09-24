document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".recipe-rating .star");

    stars.forEach((star) => {
        star.addEventListener("click", function () {
            const rating = this.getAttribute("data-value");
            const recipe_id = this.closest(
                "div.single-recipe .recipe-rating"
            ).getAttribute("data-recipe-id");

            jQuery.ajax({
                type: "POST",
                url: aarrRating.ajax_url,
                data: {
                    action: "submit_rating",
                    rating: rating,
                    recipe_id: recipe_id,
                    security: aarrRating.nonce,
                },
                success: function (response) {
                    if (response.success) {
                        const averageRating = response.data.avg_rating;

                        stars.forEach((star) => {
                            const starValue = parseInt(
                                star.getAttribute("data-value")
                            );
                            if (starValue <= averageRating) {
                                star.innerHTML = "&#9733;"; // filled star
                            } else {
                                star.innerHTML = "&#9734;"; // empty star
                            }
                        });

                        alert("Thank you for your rating!");
                    } else {
                        alert("Error: " + response.data);
                    }
                },
            });
        });
    });
});
