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
            $name = !empty($c['city_name']) ? trim($c['city_name']) : (!empty($c['name']) ? trim($c['name']) : '');
            $highlight = !empty($c['highlight']);
            // Allow admin full flexibility to customize status text
            $status = isset($c['status']) && $c['status'] !== '' ? trim($c['status']) : (!empty($c['status_badge']) ? trim($c['status_badge']) : '');
        } else {
            $name = trim((string)$c);
            $highlight = false;
            $status = '';
        }
        if ( ! empty($name) ) {
            $is_special = $highlight || ( strpos($name, '✓') !== false );

            // Provide natural fallback status for special highlighted cities if empty
            if ( $is_special && $status === '' ) {
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

// Fallback to Australian coverage list if empty
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

// Creative palette of theme-derived colorways for normal city pills
$colorways = array(
    array('bg' => '#f0fdfa', 'border' => '#99f6e4', 'text' => '#134e4a'), // brand-50 / brand-900 (Theme Mint)
    array('bg' => '#ecfdf5', 'border' => '#a7f3d0', 'text' => '#065f46'), // emerald-50 / emerald-900 (Emerald)
    array('bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#78350f'), // amber-50 / amber-900 (Warm Amber)
    array('bg' => '#ffffff', 'border' => '#e2e8f0', 'text' => '#09152b'), // white / ink-900 (Pure White)
    array('bg' => '#ccfbf1', 'border' => '#5eead4', 'text' => '#0f766e'), // brand-100 / brand-700 (Teal)
    array('bg' => '#f0f9ff', 'border' => '#bae6fd', 'text' => '#0c4a6e'), // sky-50 / sky-900 (Coastal Sky)
    array('bg' => '#fff7ed', 'border' => '#fed7aa', 'text' => '#9a3412'), // orange-50 / orange-900 (Warm Sand)
);
?>

<section class="py-16 md:py-20 text-white select-none border-y" data-module="delivery-cities" style="background: linear-gradient(180deg, #134e4a 0%, #115e59 50%, #0f4a43 100%); border-color: #0f766e;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <?php if ( ! empty($badge) ) : ?>
        <!-- Creative Multi-Segment Shipping Nationwide Eyebrow Badge -->
        <div class="inline-flex items-center p-1 pr-3.5 sm:pr-4 rounded-full border shadow-sm mb-5 transition-transform hover:scale-[1.02]"
             style="background-color: rgba(240, 253, 250, 0.12); border-color: rgba(153, 246, 228, 0.35);">
            
            <!-- Leading Accent Icon Circle -->
            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full shadow-xs shrink-0"
                  style="background-color: #5eead4; color: #134e4a;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            </span>

            <!-- Main Badge Label -->
            <span class="ml-2.5 text-[11px] font-bold uppercase tracking-widest text-brand-100">
                <?php echo esc_html($badge); ?>
            </span>

            <!-- Creative Secondary Badge Tag -->
            <span class="ml-2.5 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider"
                  style="background-color: rgba(15, 118, 110, 0.65); color: #ccfbf1; border: 1px solid rgba(94, 234, 212, 0.35);">
                All AU Metro & Regional
            </span>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-white mb-3">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-10 font-normal" style="color: rgba(204, 251, 241, 0.85);">
            <?php echo esc_html($subtitle); ?>
        </p>
        <?php endif; ?>

        <!-- Cities Badges Container (No bullet icons, small status text below city, creative theme colorways) -->
        <div class="flex flex-wrap justify-center items-center gap-2.5 sm:gap-3 max-w-5xl mx-auto">
            <?php 
            $normal_idx = 0;
            foreach ( $cities as $c ) : 
                $c_name = $c['name'];
                $is_special = !empty($c['highlight']);
                $c_status = !empty($c['status']) ? $c['status'] : '';
            ?>
                <?php if ( $is_special ) : ?>
                <!-- Special Highlight City Card: Elevated Pure White Card with Small Status Below (NO BULLETS) -->
                <div class="inline-flex flex-col items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all duration-150 cursor-default shadow-md hover:-translate-y-0.5 hover:shadow-lg border-2"
                     style="background-color: #ffffff; color: #09152b; border-color: #5eead4;">
                    
                    <span class="leading-tight"><?php echo esc_html($c_name); ?></span>

                    <?php if ( ! empty($c_status) ) : ?>
                    <!-- Small Status Text Placed Below City -->
                    <span class="mt-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider shrink-0 shadow-xs"
                          style="background-color: #0d9488; color: #ffffff;">
                        <?php echo esc_html($c_status); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <?php else : 
                    $cw = $colorways[$normal_idx % count($colorways)];
                    $normal_idx++;
                ?>
                <!-- Normal City Pill: Creative Theme Colorway (NO BULLETS, optional status below) -->
                <div class="inline-flex <?php echo !empty($c_status) ? 'flex-col items-center justify-center py-2 sm:py-2.5 rounded-2xl' : 'items-center py-2 rounded-full'; ?> px-4 text-xs sm:text-sm font-semibold transition-all duration-150 cursor-default shadow-xs hover:-translate-y-0.5 hover:shadow-sm border"
                     style="background-color: <?php echo esc_attr($cw['bg']); ?>; border-color: <?php echo esc_attr($cw['border']); ?>; color: <?php echo esc_attr($cw['text']); ?>;">
                    <span class="leading-tight"><?php echo esc_html($c_name); ?></span>
                    <?php if ( ! empty($c_status) ) : ?>
                    <span class="mt-0.5 text-[9px] font-bold uppercase tracking-wider opacity-80 leading-none">
                        <?php echo esc_html($c_status); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
