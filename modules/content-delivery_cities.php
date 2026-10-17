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

            // Provide intelligent fallback status for special highlighted cities if empty
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

// Fallback to rich Australian coverage list if empty
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

<section class="delivery-cities-section relative py-16 md:py-24 overflow-hidden select-none" data-module="delivery-cities" style="background: radial-gradient(ellipse 80% 60% at 50% -10%, #0d4231 0%, #062b1e 50%, #031710 100%); border-top: 1px solid rgba(52, 211, 153, 0.25); border-bottom: 1px solid rgba(0, 0, 0, 0.45);">
    
    <!-- Ambient Dynamic Lighting & Gradients -->
    <div class="absolute -top-36 left-1/2 -translate-x-1/2 w-[700px] h-[350px] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, transparent 70%); filter: blur(50px);" aria-hidden="true"></div>
    <div class="absolute -bottom-24 -left-20 w-80 h-80 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(20, 184, 166, 0.16) 0%, transparent 70%); filter: blur(60px);" aria-hidden="true"></div>
    <div class="absolute -bottom-24 -right-20 w-80 h-80 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%); filter: blur(60px);" aria-hidden="true"></div>

    <!-- Micro-dot texture overlay for rich tactile depth -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(255, 255, 255, 0.35) 1px, transparent 1px); background-size: 24px 24px; mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%);" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <?php if ( ! empty($badge) ) : ?>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-widest mb-4 shadow-sm" style="background: rgba(16, 185, 129, 0.14); border: 1px solid rgba(52, 211, 153, 0.35); color: #6ee7b7; backdrop-filter: blur(8px);">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #34d399;"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            <span><?php echo esc_html($badge); ?></span>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-white mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-10 font-normal" style="color: rgba(209, 250, 229, 0.85);">
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
                <!-- Special Highlight City Card (Prominent Glowing Gradient + Live Pulse Beacon + Status Tag) -->
                <div class="delivery-cities-pill-special inline-flex items-center gap-2 sm:gap-2.5 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200 cursor-default shadow-md"
                     style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.16) 0%, rgba(16, 185, 129, 0.22) 100%); border-color: rgba(251, 191, 36, 0.55); color: #ffffff; backdrop-filter: blur(12px); box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.4), 0 0 14px rgba(251, 191, 36, 0.2);">
                    
                    <!-- Live Pulse Radar Beacon -->
                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color: #fbbf24;"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background-color: #fbbf24; box-shadow: 0 0 10px rgba(251, 191, 36, 0.9);"></span>
                    </span>

                    <!-- City Name -->
                    <span class="font-bold text-white tracking-wide"><?php echo esc_html($c_name); ?></span>

                    <!-- Status Text Indicator Badge -->
                    <?php if ( ! empty($c_status) ) : ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0"
                          style="background: rgba(251, 191, 36, 0.22); color: #fef08a; border: 1px solid rgba(251, 191, 36, 0.45);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: #fbbf24;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><?php echo esc_html($c_status); ?></span>
                    </span>
                    <?php endif; ?>
                </div>

                <?php else : ?>
                <!-- Normal City Pill (Matches Previous Highlight: Polished Frosted Glass Badge + Glowing Emerald Indicator Dot) -->
                <div class="delivery-cities-pill-normal inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200 shadow-sm cursor-default"
                     style="background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.18); color: #f1f5f9; backdrop-filter: blur(8px); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: #34d399; box-shadow: 0 0 8px rgba(52, 211, 153, 0.8);"></span>
                    <span class="text-white/90 font-medium"><?php echo esc_html($c_name); ?></span>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.delivery-cities-pill-normal:hover {
    background: rgba(255, 255, 255, 0.14) !important;
    border-color: rgba(52, 211, 153, 0.45) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
}
.delivery-cities-pill-special:hover {
    border-color: rgba(251, 191, 36, 0.8) !important;
    box-shadow: 0 6px 24px -2px rgba(0, 0, 0, 0.45), 0 0 20px rgba(251, 191, 36, 0.35) !important;
    transform: translateY(-2px);
}
</style>
