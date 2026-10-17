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

<section class="py-16 md:py-20 bg-stone-50 border-y border-ink-100" data-module="delivery-cities">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <?php if ( ! empty($badge) ) : ?>
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-widest bg-brand-50 text-brand-700 border border-brand-200 mb-4 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            <?php echo esc_html($badge); ?>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-ink-900 mb-3">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-ink-500 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-10 font-normal">
            <?php echo esc_html($subtitle); ?>
        </p>
        <?php endif; ?>

        <!-- Cities Badges Container (wrapped, non-clickable pills) -->
        <div class="flex flex-wrap justify-center items-center gap-2.5 sm:gap-3 max-w-4xl mx-auto">
            <?php foreach ( $cities as $c ) : 
                $c_name = $c['name'];
                $is_special = !empty($c['highlight']) || strpos($c_name, '✓') !== false;
            ?>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full <?php echo $is_special ? 'bg-brand-50 border-brand-300 text-brand-800' : 'bg-white border-ink-200 text-ink-800 hover:border-brand-400 hover:text-brand-700'; ?> border text-xs sm:text-sm font-semibold transition-all shadow-sm select-none cursor-default">
                <span class="w-1.5 h-1.5 rounded-full <?php echo $is_special ? 'bg-brand-600' : 'bg-emerald-500'; ?> shrink-0"></span>
                <span><?php echo esc_html($c_name); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
