# Armodafinil Australia theme

Classic PHP theme for armodafinilaustralia.com.au (Steven Waldberg network): ACF Pro flexible
content, WooCommerce and Tailwind CSS 3. Design: [docs/DESIGN.md](docs/DESIGN.md). Plan and status:
[docs/REDESIGN-PLAN.md](docs/REDESIGN-PLAN.md). Project rules: [AGENTS.md](AGENTS.md) and the master SOP
(`Wordpress Needs/STEVEN-WALDBERG-WP-PROJECT-SOP.md`).

## Rules that apply to every change

- No copy, prices, phone numbers, emails or images in PHP. Everything visible comes from ACF (page
  modules or Theme Settings), WooCommerce data or menus. A module with empty fields prints nothing
  (`inc/render-modules.php` also drops any module that renders no visible text or media).
- No emojis, no long dashes, no plugin edits (use hooks and template overrides).
- Use the component classes in `input.css` (`btn-buy`, `btn-primary`, `btn-outline`, `badge`, `section`,
  `container-site`, `armo-prose`) and the colour tokens. No raw hex in templates. "Eyebrow" is called
  "badge" everywhere. No Trustpilot or third-party review badges.

## Development

```bash
npm ci
npm run build   # input.css -> style.css (commit style.css)
npm run watch
```

PHP is not on PATH on the Laragon machine: use `C:\laragon6\bin\php\php-8.1.10-Win32-vs16-x64\php.exe`.
Fonts (Inter, Poppins) are self-hosted in `assets/fonts/`.

## Where content lives

| What | Where in WP Admin |
|---|---|
| Announcement bar, feature bar, header buttons, search wording, logo alt | Theme Settings > Header, Search |
| Phone, WhatsApp, email, address, social links | Theme Settings > Contact |
| Footer text, columns headings, medical disclaimer, payment logos | Theme Settings > Footer |
| Buttons and labels used across the theme (buy button, read more, reviews, cart, checkout, 404) | Theme Settings > Interface Labels |
| Thank you page wording and steps | Theme Settings > Thank You |
| Product page notices, trust items, free shipping threshold | Theme Settings > Product Page |
| Closing call-to-action band | Theme Settings > Closing CTA |
| Blog heading and intro | Theme Settings > Blog |
| Google Analytics ID | Theme Settings > Tracking |
| Page sections (existing content) | Pages > Edit > Modules (field `modules`, drawn by `modules-legacy/`) |
| Page sections (new layouts) | Pages > Edit > Page Modules (field `page_modules`, drawn by `modules/`) |
| Product text, price note, tabs | Products > Edit (ACF fields `price_subtext`, `shop_page_text`, `extra_tabs`) |
| Reviews | Reviews (post type `reviews`, fields `rating`, `name`, `linked_product`) |
| Menus (primary, mobile, 3 footer columns) | Appearance > Menus |
| Bank details | WooCommerce > Payments > Direct bank transfer |

## Code map

- `inc/render-modules.php` prints both module fields. `inc/live-compat.php` keeps the live site's URLs
  (`/shop/<product>/`), redirects, review form and review loader working.
- `inc/product-helpers.php` rating summary, quantity options, star markup. `inc/schema.php` adds
  aggregateRating and FAQPage to the All in One SEO graph.
- `inc/checkout-medical.php` stores the Medical Conditions answers on the order.
  `inc/shipping-label.php` splits shipping method labels into name and delivery time.
- `template-parts/product-card.php` is the single product card (carousel, grids, shop).
- `assets/js/*.js` are plain scripts (no build step): site, search, product-card, product-page,
  reviews, checkout.

## Git and deployment

- `dev`: shared staging branch (InstaWP). `main`: production, merged from `dev` only after client approval.
- Feature work happens on `issue/<n>-...` branches and reaches `dev` through a pull request.
- Before every push run the SOP checks (php -l, long dashes/mojibake, emojis, `A$`, hardcoded copy).
- cPanel: Git Version Control, branch `main`, path `public_html/wp-content/themes/<theme folder>`.
  The built `style.css` is committed, so no build step runs on the server.
- Switching the live site to this theme: on first activation `inc/navigation.php` copies the menu
  locations and logo from the old theme (`armodafinil-australia`).
