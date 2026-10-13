<?php
/**
 * Review Form Module Template
 */

$heading = get_sub_field('heading') ?: 'Leave us a review ✍️';
?>

<section class="py-16 md:py-24 bg-ink-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-soft p-8 md:p-12 border border-ink-200">
            <div class="text-center mb-8">
                <h2 class="font-serif text-3xl font-semibold text-ink-900 mb-3">
                    <?php echo esc_html($heading); ?>
                </h2>
                <p class="text-ink-600">Your feedback helps us improve and helps others make informed decisions.</p>
            </div>

            <form id="general-review-form" class="space-y-6">
                <!-- Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="review_name" class="block text-sm font-medium text-ink-900 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="review_name" name="reviewer_name" required
                            class="w-full px-4 py-3 rounded-lg border border-ink-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label for="review_email" class="block text-sm font-medium text-ink-900 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="review_email" name="reviewer_email" required
                            class="w-full px-4 py-3 rounded-lg border border-ink-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors"
                            placeholder="john@example.com">
                        <p class="text-xs text-ink-500 mt-1">Your email will not be published.</p>
                    </div>
                </div>

                <!-- Job / Location -->
                <div>
                    <label for="review_meta" class="block text-sm font-medium text-ink-900 mb-2">Job / Location <span class="text-ink-400 font-normal">(Optional)</span></label>
                    <input type="text" id="review_meta" name="reviewer_meta"
                        class="w-full px-4 py-3 rounded-lg border border-ink-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors"
                        placeholder="e.g. Verified Buyer, Developer from Sydney">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-900 mb-2">Rating <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-2 star-rating-input cursor-pointer" id="form-star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" data-rating="<?php echo $i; ?>" class="w-8 h-8 text-ink-300 hover:text-brand-600 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="review_rating" value="5" required>
                </div>

                <!-- Review Title -->
                <div>
                    <label for="review_title" class="block text-sm font-medium text-ink-900 mb-2">Review Summary</label>
                    <input type="text" id="review_title" name="review_title"
                        class="w-full px-4 py-3 rounded-lg border border-ink-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors"
                        placeholder="e.g. Excellent service and fast delivery!">
                </div>

                <!-- Review Content -->
                <div>
                    <label for="review_content" class="block text-sm font-medium text-ink-900 mb-2">Your Review <span class="text-red-500">*</span></label>
                    <textarea id="review_content" name="review_content" rows="4" required
                        class="w-full px-4 py-3 rounded-lg border border-ink-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors"
                        placeholder="Tell us about your experience..."></textarea>
                </div>

                <!-- Security / Nonce -->
                <input type="hidden" name="action" value="submit_product_review">
                <?php wp_nonce_field('submit_review_nonce', 'review_nonce'); ?>
                <!-- No Product ID for general review -->
                <input type="hidden" name="product_id" value="">

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submit-review-btn"
                        class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                        Submit Review
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden animate-spin" id="review-spinner" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>

                <!-- Response Message -->
                <div id="review-response-message" class="hidden rounded-lg p-4 mt-4 text-sm font-medium"></div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starContainer = document.getElementById('form-star-rating');
    const ratingInput = document.getElementById('review_rating');
    const stars = starContainer.querySelectorAll('svg');

    // Star Rating Hover & Click Logic
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const val = parseInt(this.getAttribute('data-rating'));
            highlightStars(val);
        });

        star.addEventListener('mouseout', function() {
            const currentVal = parseInt(ratingInput.value);
            highlightStars(currentVal);
        });

        star.addEventListener('click', function() {
            const val = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = val;
            highlightStars(val);
        });
    });

    function highlightStars(val) {
        stars.forEach(s => {
            if (parseInt(s.getAttribute('data-rating')) <= val) {
                s.classList.remove('text-ink-300');
                s.classList.add('text-brand-600');
            } else {
                s.classList.add('text-ink-300');
                s.classList.remove('text-brand-600');
            }
        });
    }
    // Initialize default (5)
    highlightStars(5);

    // Form Submission Logic
    const form = document.getElementById('general-review-form');
    const submitBtn = document.getElementById('submit-review-btn');
    const spinner = document.getElementById('review-spinner');
    const msgBox = document.getElementById('review-response-message');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            spinner.classList.remove('hidden');
            msgBox.classList.add('hidden');
            msgBox.className = 'hidden rounded-lg p-4 mt-4 text-sm font-medium'; // reset

            const formData = new FormData(form);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                msgBox.classList.remove('hidden');
                if (data.success) {
                    msgBox.classList.add('bg-green-50', 'text-green-800', 'border', 'border-green-200');
                    msgBox.innerHTML = data.data.message || 'Review submitted successfully!';
                    form.reset();
                    highlightStars(5);
                    ratingInput.value = 5;
                } else {
                    msgBox.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
                    msgBox.innerHTML = data.data.message || 'An error occurred.';
                }
            })
            .catch(err => {
                msgBox.classList.remove('hidden');
                msgBox.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
                msgBox.innerHTML = 'A network error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                spinner.classList.add('hidden');
            });
        });
    }
});
</script>
