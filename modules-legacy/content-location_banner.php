<?php
/**
 * Layout: Location Banner
 * Fields: title, content, button_text, button_link
 */

$title       = get_sub_field('title') ?: 'Buy Armodafinil Online Sydney Australia';
$content     = get_sub_field('content') ?: '<p class="mb-4">Order premium Armodafinil online with trusted Australia-wide shipping, discreet packaging, secure ANZ bank payments, and responsive customer support.</p><p>Armodafinil Australia delivers across Sydney including CBD, Bondi, Parramatta, Chatswood, Manly, and surrounding suburbs with reliable service Australians trust.</p>';
$button_text = get_sub_field('button_text') ?: 'Shop Now ';
$button_link = get_sub_field('button_link') ?: '/shop/';
?>
<section class="py-12 px-6 lg:px-12 bg-[#183a6b] text-white">
    <div class="max-w-6xl mx-auto">
        <?php if ($title) : ?>
            <h2 class="text-xl md:text-2xl font-bold mb-4"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($content) : ?>
            <div class="text-base md:text-lg leading-relaxed mb-6 opacity-90">
                <?php echo armo_content($content); ?>
            </div>
        <?php endif; ?>

        <?php if ($button_text && $button_link) : ?>
            <a href="<?php echo esc_url($button_link); ?>" class="inline-flex items-center justify-center bg-accent hover:bg-[#e6b800] text-primary-dark font-bold text-lg py-3 px-6 rounded transition-colors duration-300">
                <?php echo esc_html($button_text); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
