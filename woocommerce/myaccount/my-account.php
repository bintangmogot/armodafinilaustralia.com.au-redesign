<?php
/**
 * My Account page
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full lg:w-72 shrink-0">
            <?php do_action( 'woocommerce_account_navigation' ); ?>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <div class="woocommerce-MyAccount-content !w-full !float-none bg-white rounded-2xl shadow-sm border border-ink-200 p-6 sm:p-8 lg:p-10">
                <?php do_action( 'woocommerce_account_content' ); ?>
            </div>
        </main>
        
    </div>
</div>

<style>
/* Global My Account Styling */
.woocommerce-MyAccount-content h2,
.woocommerce-MyAccount-content h3 {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-weight: 600;
    color: #09152b; /* ink-900 */
    margin-bottom: 1.25rem;
}
.woocommerce-MyAccount-content legend {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #09152b;
    margin-bottom: 1rem;
    display: block;
}
.woocommerce-MyAccount-content .form-row {
    margin-bottom: 1.25rem;
}
.woocommerce-MyAccount-content label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #334155;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.woocommerce-MyAccount-content input.input-text,
.woocommerce-MyAccount-content select,
.woocommerce-MyAccount-content textarea {
    width: 100%;
    height: 2.75rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
    box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
}
.woocommerce-MyAccount-content input.input-text:focus,
.woocommerce-MyAccount-content select:focus,
.woocommerce-MyAccount-content textarea:focus {
    border-color: #0d9488;
}
.woocommerce-MyAccount-content button.button,
.woocommerce-MyAccount-content a.button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 2.5rem;
    padding: 0 1.5rem;
    border-radius: 9999px;
    background-color: #0d9488;
    color: white !important;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.15s;
    text-decoration: none;
}
.woocommerce-MyAccount-content button.button:hover,
.woocommerce-MyAccount-content a.button:hover {
    background-color: #0f766e;
}
.woocommerce-MyAccount-content table.shop_table {
    width: 100%;
    border-collapse: separate; border-spacing: 0;
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 2rem;
}
.woocommerce-MyAccount-content table.shop_table thead th {
    background: #f8fafc;
    font-weight: 600;
    color: #09152b;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
    text-align: left;
}
.woocommerce-MyAccount-content table.shop_table th,
.woocommerce-MyAccount-content table.shop_table td {
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}
.woocommerce-MyAccount-content table.shop_table tr:last-child th,
.woocommerce-MyAccount-content table.shop_table tr:last-child td {
    border-bottom: none;
}
.woocommerce-MyAccount-content mark {
    background: #f0fdfa;
    color: #0d9488;
    font-weight: 600;
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
}
</style>

