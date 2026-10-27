<?php
/**
 * Layout: HTML
 * Fields: content (textarea - raw HTML)
 */
$content = get_sub_field('content');
?>
<?php if ($content) : ?>
    <div class="raw-html-module">
        <?php echo $content; // Raw HTML output - not escaped intentionally ?>
    </div>
<?php endif; ?>
