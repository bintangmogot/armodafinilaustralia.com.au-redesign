<?php
/**
 * Layout: Review Form
 * Fields: heading (text)
 * Design: Dark blue background section, white/light form card in center.
 * 
 * This form submits reviews via AJAX. Submitted reviews are saved as
 * 'pending' status in the Reviews CPT - the admin must approve them
 * before they appear on the frontend.
 */

$heading = get_sub_field('heading');
if ( ! $heading ) {
    $heading = 'Leave us a review ';
}
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-primary">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-10">
            <?php echo esc_html( $heading ); ?>
        </h2>

        <div class="bg-surface rounded-2xl p-8 lg:p-12 text-left shadow-xl max-w-2xl mx-auto">
            <form id="armo-review-form" method="POST" class="flex flex-col gap-6">
                <?php wp_nonce_field( 'armo_submit_review', 'armo_review_nonce' ); ?>
                <input type="hidden" name="action" value="armo_submit_review">
                <input type="hidden" name="review_rating" id="review-rating-value" value="5">

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-bold text-primary mb-2">Your overall rating *</label>
                    <div id="star-rating-selector" class="whitespace-nowrap">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<span data-rating="' . $i . '" class="star-icon text-3xl text-accent cursor-pointer transition-colors leading-none select-none inline-block mr-2"></span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-bold text-primary mb-2">Title of your review *</label>
                    <input type="text" name="review_title" placeholder="Enter your title" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:border-primary transition-colors" required>
                </div>

                <!-- Review Content -->
                <div>
                    <label class="block text-sm font-bold text-primary mb-2">Your review *</label>
                    <textarea name="review_content" placeholder="Write your review" rows="4" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:border-primary transition-colors resize-none" required></textarea>
                </div>

                <!-- Grid for Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-bold text-primary mb-2">Your name *</label>
                        <input type="text" name="review_name" placeholder="Enter your name" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:border-primary transition-colors" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-primary mb-2">Your email address *</label>
                        <input type="email" name="review_email" placeholder="Enter your email" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:border-primary transition-colors" required>
                    </div>
                </div>

                <!-- Success / Error Messages -->
                <div id="review-form-message" class="hidden rounded-lg p-4 text-sm font-medium text-center"></div>

                <!-- Submit Button -->
                <div class="mt-4 text-center">
                    <button type="submit" id="review-submit-btn" class="bg-[#FF0000] text-white font-bold py-4 px-10 rounded-full hover:bg-red-600 transition-colors w-full md:w-auto">
                        Submit your review
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Star Rating Selector ──
    const stars = document.querySelectorAll('#star-rating-selector .star-icon');
    const ratingInput = document.getElementById('review-rating-value');
    let currentRating = 5;

    function updateStars(rating) {
        stars.forEach(function(star) {
            const starRating = parseInt(star.getAttribute('data-rating'));
            if (starRating <= rating) {
                star.classList.add('text-[#EAA800]');
                star.classList.remove('text-gray-300');
            } else {
                star.classList.remove('text-[#EAA800]');
                star.classList.add('text-gray-300');
            }
        });
    }

    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            currentRating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = currentRating;
            updateStars(currentRating);
        });

        star.addEventListener('mouseenter', function() {
            updateStars(parseInt(this.getAttribute('data-rating')));
        });

        star.addEventListener('mouseleave', function() {
            updateStars(currentRating);
        });
    });

    // ── Form Submission via AJAX ──
    const form = document.getElementById('armo-review-form');
    const submitBtn = document.getElementById('review-submit-btn');
    const messageDiv = document.getElementById('review-form-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Disable button & show loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        messageDiv.classList.add('hidden');

        const formData = new FormData(form);

        fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
            method: 'POST',
            body: formData,
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            messageDiv.classList.remove('hidden');
            if (data.success) {
                messageDiv.className = 'rounded-lg p-4 text-sm font-medium text-center bg-green-100 text-green-800 border border-green-200';
                messageDiv.textContent = data.data.message;
                form.reset();
                currentRating = 5;
                updateStars(5);
                ratingInput.value = 5;
            } else {
                messageDiv.className = 'rounded-lg p-4 text-sm font-medium text-center bg-red-100 text-red-800 border border-red-200';
                messageDiv.textContent = data.data.message || 'Something went wrong. Please try again.';
            }
        })
        .catch(function() {
            messageDiv.classList.remove('hidden');
            messageDiv.className = 'rounded-lg p-4 text-sm font-medium text-center bg-red-100 text-red-800 border border-red-200';
            messageDiv.textContent = 'Connection error. Please try again.';
        })
        .finally(function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit your review';
        });
    });
});
</script>
