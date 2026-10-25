<?php
/**
 * Layout: Breadcrumb
 * Fields: (none) - auto-generates breadcrumb from page hierarchy
 */
?>
<nav class="bg-gray-50 py-3 px-4 border-b border-gray-200">
    <div class="max-w-7xl mx-auto text-sm text-gray-500">
        <a href="<?php echo home_url('/'); ?>" class="hover:text-gray-900">Home</a>
        <?php
        // Build breadcrumb from page ancestors
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo ' <span class="mx-1">›</span> ';
                echo '<a href="' . get_permalink($ancestor) . '" class="hover:text-gray-900">' . get_the_title($ancestor) . '</a>';
            }
        }
        ?>
        <span class="mx-1">›</span>
        <span class="text-gray-900"><?php the_title(); ?></span>
    </div>
</nav>
