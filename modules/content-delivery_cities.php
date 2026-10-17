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
            $status = !empty($c['status']) ? $c['status'] : (!empty($c['status_badge']) ? $c['status_badge'] : '');
        } else {
            $name = (string)$c;
            $highlight = false;
            $status = '';
        }
        if ( ! empty($name) ) {
            $is_special = $highlight || ( strpos($name, '✓') !== false );

            // Provide natural fallback status for special highlighted cities if empty
            if ( $is_special && empty($status) ) {
                if ( stripos($name, 'Sydney') !== false || stripos($name, 'Melbourne') !== false ) {
                    $status = 'Same-Day Dispatch';
                } elseif ( stripos($name, 'Brisbane') !== false ) {
                    $status = 'Express Metro';
                } elseif ( stripos($name, 'Remote') !== false || stripos($name, 'Regional') !== false || strpos($name, '✓') !== false ) {
                    $status = '100% AU-Wide';
                } else {
                    $status = 'Express Hub';
                }
            }

            $cities[] = array(
                'name'      => $name,
                'highlight' => $is_special,
                'status'    => $status,
            );
        }
    }
}

// Fallback to natural Australian coverage list if empty
if ( empty( $cities ) ) {
    $cities = array(
        array('name' => 'Sydney NSW', 'highlight' => true, 'status' => 'Same-Day Dispatch'),
        array('name' => 'Melbourne VIC', 'highlight' => true, 'status' => 'Same-Day Dispatch'),
        array('name' => 'Brisbane QLD', 'highlight' => true, 'status' => 'Express Metro'),
        array('name' => 'Perth WA', 'highlight' => false, 'status' => ''),
        array('name' => 'Adelaide SA', 'highlight' => false, 'status' => ''),
        array('name' => 'Gold Coast QLD', 'highlight' => false, 'status' => ''),
        array('name' => 'Canberra ACT', 'highlight' => false, 'status' => ''),
        array('name' => 'Newcastle NSW', 'highlight' => false, 'status' => ''),
        array('name' => 'Darwin NT', 'highlight' => false, 'status' => ''),
        array('name' => 'Hobart TAS', 'highlight' => false, 'status' => ''),
        array('name' => 'Cairns QLD', 'highlight' => false, 'status' => ''),
        array('name' => 'Geelong VIC', 'highlight' => false, 'status' => ''),
        array('name' => 'Townsville QLD', 'highlight' => false, 'status' => ''),
        array('name' => 'Wollongong NSW', 'highlight' => false, 'status' => ''),
        array('name' => 'Regional & Remote ✓', 'highlight' => true, 'status' => '100% AU-Wide'),
    );
}
?>

<section class="py-16 md:py-20 text-white select-none" data-module="delivery-cities" style="background-color: #123428;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <?php if ( ! empty($badge) ) : ?>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wider mb-4 border" style="background-color: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.16); color: rgba(255, 255, 255, 0.9);">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-300 shrink-0"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            <span><?php echo esc_html($badge); ?></span>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-white mb-3">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-10 font-normal" style="color: rgba(236, 253, 245, 0.75);">
            <?php echo esc_html($subtitle); ?>
        </p>
        <?php endif; ?>

        <!-- Cities Badges Container (wrapped, non-clickable pills) -->
        <div class="flex flex-wrap justify-center items-center gap-2.5 sm:gap-3 max-w-5xl mx-auto">
            <?php foreach ( $cities as $c ) : 
                $c_name = $c['name'];
                $is_special = !empty($c['highlight']);
                $c_status = !empty($c['status']) ? $c['status'] : '';
            ?>
                <?php if ( $is_special ) : ?>
                <!-- Special Highlight City Card: Crisp Solid White Pill with Status Chip -->
                <div class="delivery-cities-pill-special inline-flex items-center gap-2 sm:gap-2.5 px-3.5 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-transform duration-150 cursor-default shadow-sm hover:-translate-y-0.5"
                     style="background-color: #ffffff; color: #0f172a; border: 1px solid #ffffff;">
                    
                    <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: #059669;"></span>

                    <span class="font-bold text-slate-900"><?php echo esc_html($c_name); ?></span>

                    <?php if ( ! empty($c_status) ) : ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide shrink-0"
                          style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                        <?php echo esc_html($c_status); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <?php else : ?>
                <!-- Normal City Pill: Subtle Translucent Capsule with Clean Dot -->
                <div class="delivery-cities-pill-normal inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition-colors duration-150 cursor-default"
                     style="background-color: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.16); color: rgba(255, 255, 255, 0.9);">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: #34d399;"></span>
                    <span><?php echo esc_html($c_name); ?></span>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.delivery-cities-pill-normal:hover {
    background-color: rgba(255, 255, 255, 0.14) !important;
    border-color: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
}
</style>
