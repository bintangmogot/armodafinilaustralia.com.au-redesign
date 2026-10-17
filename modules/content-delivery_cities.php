<?php
/**
 * Delivery Cities / Nationwide Module Template
 * 
 * Data provided by ACF Sub Fields: badge, title, subtitle, cities
 */

$badge = get_sub_field('badge') ?: 'SHIPPING NATIONWIDE';
$title = get_sub_field('title') ?: 'Delivered Everywhere in Australia';
$subtitle = get_sub_field('subtitle') ?: 'Metro cities, regional towns, or remote FIFO camps — we ship to your address.';
$cities_field = get_sub_field('cities');

$cities = array();

if ( ! empty( $cities_field ) && is_array( $cities_field ) ) {
    foreach ( $cities_field as $c ) {
        if ( is_array($c) ) {
            $name = !empty($c['city_name']) ? $c['city_name'] : (!empty($c['name']) ? $c['name'] : '');
            $highlight = !empty($c['highlight']);
        } else {
            $name = (string)$c;
            $highlight = false;
        }
        if ( ! empty($name) ) {
            $cities[] = array(
                'name'      => $name,
                'highlight' => $highlight,
            );
        }
    }
}

// Fallback to default Australian coverage list if empty
if ( empty( $cities ) ) {
    $cities = array(
        array('name' => 'Sydney NSW', 'highlight' => false),
        array('name' => 'Melbourne VIC', 'highlight' => false),
        array('name' => 'Brisbane QLD', 'highlight' => false),
        array('name' => 'Perth WA', 'highlight' => false),
        array('name' => 'Adelaide SA', 'highlight' => false),
        array('name' => 'Darwin NT', 'highlight' => false),
        array('name' => 'Hobart TAS', 'highlight' => false),
        array('name' => 'Canberra ACT', 'highlight' => false),
        array('name' => 'Gold Coast QLD', 'highlight' => false),
        array('name' => 'Newcastle NSW', 'highlight' => false),
        array('name' => 'Cairns QLD', 'highlight' => false),
        array('name' => 'Wollongong NSW', 'highlight' => false),
        array('name' => 'Geelong VIC', 'highlight' => false),
        array('name' => 'Townsville QLD', 'highlight' => false),
        array('name' => 'Regional & Remote ✓', 'highlight' => true),
    );
}
?>

<section class="py-16 md:py-24 bg-[#082017] text-white relative overflow-hidden" data-module="delivery-cities">
    <!-- Subtle gradient glow -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/30 pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <?php if ( ! empty($badge) ) : ?>
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-widest bg-amber-400/10 text-amber-300 border border-amber-400/25 mb-4 shadow-sm">
            <?php echo esc_html($badge); ?>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-white mb-3">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-emerald-100/75 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-10 font-normal">
            <?php echo esc_html($subtitle); ?>
        </p>
        <?php endif; ?>

        <!-- Cities Badges Container -->
        <div class="relative max-w-5xl mx-auto flex items-center justify-center">
            <!-- Left arrow indicator -->
            <div class="hidden xl:flex absolute -left-6 w-9 h-9 rounded-full bg-white/5 border border-white/10 items-center justify-center text-white/40 pointer-events-none select-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </div>

            <!-- Cities list (wrapped, non-clickable pills) -->
            <div class="flex flex-wrap justify-center items-center gap-2.5 sm:gap-3 max-w-4xl mx-auto px-2">
                <?php foreach ( $cities as $c ) : 
                    $c_name = $c['name'];
                    $is_special = !empty($c['highlight']) || strpos($c_name, '✓') !== false;
                ?>
                <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-full <?php echo $is_special ? 'bg-amber-400/15 border-amber-400/30 text-amber-200' : 'bg-white/[0.06] border-white/15 text-white/90 hover:bg-white/10 hover:border-white/25'; ?> border text-xs sm:text-sm font-semibold transition-all select-none shadow-sm backdrop-blur-sm cursor-default">
                    <span class="w-1.5 h-1.5 rounded-full <?php echo $is_special ? 'bg-amber-300' : 'bg-amber-400'; ?> shrink-0"></span>
                    <span><?php echo esc_html($c_name); ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Right arrow indicator -->
            <div class="hidden xl:flex absolute -right-6 w-9 h-9 rounded-full bg-white/5 border border-white/10 items-center justify-center text-white/40 pointer-events-none select-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </div>
        </div>
    </div>
</section>
