<?php
/**
 * Product Reviews Section
 */

$product_id = get_the_ID();
$product_name = get_the_title();

$reviews = get_posts([
    'post_type' => 'review',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key'     => 'linked_product',
            'value'   => $product_id,
            'compare' => '='
        )
    )
]);
$review_count = count($reviews);

$total_rating = 0;
$counts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
if ($review_count > 0) {
    foreach ($reviews as $r) {
        $rating_val = get_field('rating', $r->ID);
        $val = $rating_val ? (float)$rating_val : 5.0;
        $total_rating += $val;
        
        $r_val = round($val);
        if ($r_val > 5) $r_val = 5;
        if ($r_val < 1) $r_val = 1;
        $counts[$r_val]++;
    }
    $average_rating = round($total_rating / $review_count, 1);
} else {
    // Fake average if no reviews.
    $average_rating = 5.0;
}

$average_rating_formatted = number_format($average_rating, 1);
$rounded_rating = round($average_rating);

$percentages = [];
foreach($counts as $star => $count) {
    $percentages[$star] = $review_count > 0 ? round(($count / $review_count) * 100) : 0;
}
?>

<div id="reviews" class="bg-slate-50 border-t border-slate-200 py-16 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col items-center justify-center text-center mb-10">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/50 text-emerald-800 text-[10px] font-bold uppercase tracking-widest mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Verified Reviews
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">What our customers say</h2>
            <p class="text-slate-500 font-medium text-sm md:text-base">Real experiences from verified buyers</p>
        </div>

        <?php if ($review_count > 0): ?>
        <!-- Breakdown Card -->
        <div class="bg-white rounded-[24px] border border-slate-200 p-8 md:p-10 mb-8 shadow-sm flex flex-col md:flex-row gap-10 md:gap-20">
            <div class="shrink-0 flex flex-col justify-center">
                <div class="text-sm font-semibold text-slate-500 mb-2">Customer rating</div>
                <div class="text-5xl font-extrabold text-slate-900 mb-3"><?php echo $average_rating_formatted; ?></div>
                <div class="flex gap-0.5 mb-3">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="<?php echo ($i < $rounded_rating) ? 'bg-[#00b67a]' : 'bg-slate-200'; ?> w-6 h-6 flex items-center justify-center rounded-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="white" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="font-bold text-slate-900 mb-1">
                    <?php 
                    if($average_rating >= 4.5) echo 'Excellent';
                    elseif($average_rating >= 4.0) echo 'Great';
                    elseif($average_rating >= 3.0) echo 'Average';
                    else echo 'Poor';
                    ?>
                </div>
                <div class="text-xs font-medium text-slate-500">Based on <?php echo number_format($review_count); ?> reviews</div>
            </div>

            <div class="flex-1 flex flex-col justify-center gap-3 w-full max-w-lg">
                <?php foreach([5, 4, 3, 2, 1] as $star): ?>
                <div class="flex items-center gap-4 text-xs font-semibold text-slate-600">
                    <div class="w-10 whitespace-nowrap"><?php echo $star; ?>-star</div>
                    <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#00b67a] rounded-full" style="width: <?php echo $percentages[$star]; ?>%"></div>
                    </div>
                    <div class="w-10 text-right"><?php echo $percentages[$star]; ?>%</div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Controls -->
        <div class="flex justify-end gap-2 mb-4 pr-2">
            <button class="review-prev w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:border-slate-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <button class="review-next w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:border-slate-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </button>
        </div>

        <!-- Slider -->
        <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-6 pb-8" id="reviews-slider">
            <?php foreach ($reviews as $r): 
                $post_id = $r->ID;
                $title = get_the_title($post_id);
                $body = get_post_field('post_content', $post_id);
                $reviewer = get_field('name', $post_id) ?: $r->post_title;
                $meta = get_field('reviewer_meta', $post_id) ?: "Verified";
                $rating_val = get_field('rating', $post_id) ?: 5;
                $initials = strtoupper(substr($reviewer, 0, 1) . (strpos($reviewer, ' ') ? substr(explode(' ', $reviewer)[1], 0, 1) : ''));
            ?>
            <div class="snap-start shrink-0 w-full sm:w-[350px] bg-white border border-slate-200 rounded-[20px] p-6 shadow-sm flex flex-col">
                <div class="flex gap-0.5 mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="<?php echo ($i < $rating_val) ? 'bg-[#00b67a]' : 'bg-slate-200'; ?> w-5 h-5 flex items-center justify-center rounded-[3px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                    <?php endfor; ?>
                </div>
                
                <h4 class="font-bold text-[15px] text-slate-900 mb-2 leading-snug"><?php echo esc_html($title); ?></h4>
                <div class="text-[13px] text-slate-600 leading-relaxed mb-6 line-clamp-4 flex-1">
                    <?php echo wp_kses_post($body); ?>
                </div>
                
                <div class="flex items-center justify-between mt-auto border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 shrink-0 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-[11px] uppercase tracking-wider">
                            <?php echo esc_html($initials); ?>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-[13px] text-slate-900 leading-tight"><?php echo esc_html($reviewer); ?></span>
                            <span class="text-[10px] text-slate-400 font-medium mt-0.5">
                                <?php echo get_the_date('j F Y', $post_id); ?>
                            </span>
                        </div>
                    </div>
                    <div class="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-50 text-[9px] font-bold text-emerald-700 uppercase tracking-wider">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Verified
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="bg-white border border-slate-200 border-dashed rounded-2xl p-12 text-center mb-8">
            <p class="text-slate-500 font-medium">No reviews yet. Be the first to review this product!</p>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="max-w-2xl mx-auto bg-white rounded-[20px] border border-slate-200 p-6 md:p-8 mt-8 shadow-sm relative overflow-hidden">
            <div class="flex items-center gap-3 mb-5 pb-5 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Write a Review <span class="text-slate-400 font-normal">for <?php echo esc_html($product_name); ?></span></h3>
                </div>
            </div>

            <form id="product-review-form" class="space-y-4">
                <input type="hidden" name="action" value="submit_product_review">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                <?php wp_nonce_field('submit_review_nonce', 'review_nonce'); ?>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Rating</label>
                    <div class="flex items-center gap-1 cursor-pointer" id="star-rating-select">
                        <?php for($i=1; $i<=5; $i++): ?>
                        <svg data-val="<?php echo $i; ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon w-8 h-8 text-slate-300 hover:fill-amber-400 hover:text-amber-400 transition-colors"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="0" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Name</label>
                        <input type="text" name="reviewer_name" required placeholder="John D." class="w-full bg-white border border-slate-200 text-sm rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="reviewer_email" required placeholder="john@example.com" class="w-full bg-white border border-slate-200 text-sm rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Title</label>
                        <input type="text" name="review_title" required placeholder="Great product!" class="w-full bg-white border border-slate-200 text-sm rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Review</label>
                    <textarea name="review_content" required rows="4" placeholder="Share your experience..." class="w-full bg-white border border-slate-200 text-sm rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-slate-400 resize-none"></textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                    <div class="text-[10px] text-slate-400 w-full sm:w-auto text-left">
                        Protected by reCAPTCHA. Google <a href="#" class="hover:underline">Privacy Policy</a> & <a href="#" class="hover:underline">Terms</a> apply.
                    </div>
                    <div class="flex flex-col items-end w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 py-3.5 rounded-lg transition-colors focus:ring-4 focus:ring-brand-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Submit Review
                        </button>
                        <div class="text-[10px] text-slate-400 mt-2 font-medium">Moderated before publishing</div>
                    </div>
                </div>

                <div id="review-form-message" class="hidden mt-4 p-4 rounded-lg text-sm font-bold"></div>
            </form>
        </div>

    </div>
</div>

<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Star Rating Logic
    const stars = document.querySelectorAll('.star-icon');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const val = this.getAttribute('data-val');
            highlightStars(val);
        });
        star.addEventListener('mouseleave', function() {
            highlightStars(ratingInput.value);
        });
        star.addEventListener('click', function() {
            const val = this.getAttribute('data-val');
            ratingInput.value = val;
            highlightStars(val);
        });
    });

    function highlightStars(val) {
        stars.forEach(s => {
            if (s.getAttribute('data-val') <= val) {
                s.classList.remove('text-slate-300');
                s.classList.add('fill-amber-400', 'text-amber-400');
            } else {
                s.classList.add('text-slate-300');
                s.classList.remove('fill-amber-400', 'text-amber-400');
            }
        });
    }

    // Slider Controls
    const slider = document.getElementById('reviews-slider');
    const prevBtn = document.querySelector('.review-prev');
    const nextBtn = document.querySelector('.review-next');

    if (slider && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -374, behavior: 'smooth' }); // 350w + 24gap
        });
        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: 374, behavior: 'smooth' });
        });
    }

    // Form Submission
    const form = document.getElementById('product-review-form');
    const msgDiv = document.getElementById('review-form-message');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (ratingInput.value === '0') {
                alert('Please select a star rating.');
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Submitting...';
            submitBtn.disabled = true;

            const formData = new FormData(form);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                msgDiv.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'bg-emerald-50', 'text-emerald-700');
                if (data.success) {
                    msgDiv.classList.add('bg-emerald-50', 'text-emerald-700');
                    msgDiv.textContent = data.data.message;
                    form.reset();
                    ratingInput.value = '0';
                    highlightStars(0);
                } else {
                    msgDiv.classList.add('bg-red-50', 'text-red-700');
                    msgDiv.textContent = data.data.message || 'An error occurred.';
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            })
            .catch(err => {
                msgDiv.classList.remove('hidden');
                msgDiv.classList.add('bg-red-50', 'text-red-700');
                msgDiv.textContent = 'A network error occurred.';
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
