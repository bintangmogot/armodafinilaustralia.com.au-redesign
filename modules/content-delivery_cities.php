<?php
/**
 * Delivery Cities / Nationwide Module Template
 * 
 * Data provided by ACF Sub Fields: badge, title, subtitle, cities
 */

$badge = get_sub_field('badge');
$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
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
            $is_special = $highlight || ( strpos($name, '') !== false );

            // Provide natural fallback status for special highlighted cities if empty
            if ( $is_special && $status === '' ) {
                if ( stripos($name, 'Sydney') !== false || stripos($name, 'Melbourne') !== false ) {
                    $status = 'Same-Day Dispatch';
                } elseif ( stripos($name, 'Brisbane') !== false ) {
                    $status = 'Express Metro';
                } elseif ( stripos($name, 'Remote') !== false || stripos($name, 'Regional') !== false || strpos($name, '') !== false ) {
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
    $cities = array();
}

// Creative palette of theme-derived colorways for normal city pills
$colorways = array();
?>

<section class="py-14 md:py-18 text-white select-none border-y" data-module="delivery-cities" style="background: linear-gradient(180deg, #134e4a 0%, #115e59 50%, #0f4a43 100%); border-color: #0f766e;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <?php if ( ! empty($badge) ) : ?>
        <!-- Micro-Proportioned Refined Shipping Nationwide Badge Badge -->
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full border shadow-xs mb-3 transition-transform hover:scale-[1.02]"
             style="background-color: rgba(240, 253, 250, 0.10); border-color: rgba(94, 234, 212, 0.3); color: #ccfbf1;">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #5eead4;"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-widest leading-none">
                <?php echo esc_html($badge); ?>
            </span>
        </div>
        <?php endif; ?>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-white mb-2.5">
            <?php echo esc_html($title); ?>
        </h2>

        <?php if ( ! empty($subtitle) ) : ?>
        <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-8 font-normal" style="color: rgba(204, 251, 241, 0.85);">
            <?php echo esc_html($subtitle); ?>
        </p>
        <?php endif; ?>

        <!-- Cities Badges Container (No bullet icons, compact status below city, creative theme colorways) -->
        <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-2.5 max-w-5xl mx-auto">
            <?php 
            $normal_idx = 0;
            foreach ( $cities as $c ) : 
                $c_name = $c['name'];
                $is_special = !empty($c['highlight']);
                $c_status = !empty($c['status']) ? $c['status'] : '';
            ?>
                <?php if ( $is_special ) : ?>
                <!-- Special Highlight City Card: Compact Pure White Card with Status Below (NO BULLETS) -->
                <div class="inline-flex flex-col items-center justify-center px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold transition-all duration-150 cursor-default shadow-xs hover:-translate-y-0.5 hover:shadow-sm border-2"
                     style="background-color: #ffffff; color: #09152b; border-color: #5eead4;">
                    
                    <span class="leading-tight"><?php echo esc_html($c_name); ?></span>

                    <?php if ( ! empty($c_status) ) : ?>
                    <!-- Compact Small Status Text Below City -->
                    <span class="mt-0.5 text-[9px] font-bold uppercase tracking-wider text-brand-700 leading-none">
                        <?php echo esc_html($c_status); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <?php else : 
                    $cw = $colorways[$normal_idx % count($colorways)];
                    $normal_idx++;
                ?>
                <!-- Normal City Pill: Creative Theme Colorway (NO BULLETS, compact status below if present) -->
                <div class="inline-flex <?php echo !empty($c_status) ? 'flex-col items-center justify-center py-1.5 sm:py-2 rounded-xl' : 'items-center py-1.5 sm:py-2 rounded-full'; ?> px-3.5 sm:px-4 text-xs sm:text-sm font-semibold transition-all duration-150 cursor-default shadow-xs hover:-translate-y-0.5 hover:shadow-sm border"
                     style="background-color: <?php echo esc_attr($cw['bg']); ?>; border-color: <?php echo esc_attr($cw['border']); ?>; color: <?php echo esc_attr($cw['text']); ?>;">
                    <span class="leading-tight"><?php echo esc_html($c_name); ?></span>
                    <?php if ( ! empty($c_status) ) : ?>
                    <span class="mt-0.5 text-[9px] font-bold uppercase tracking-wider opacity-75 leading-none">
                        <?php echo esc_html($c_status); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
