# Redesign plan: armodafinilaustralia.com.au

Branch: `issue/7-rename-theme-folder` (PR #8 into `dev`). `main` and the live site are not
touched without Bintang's approval. Design: `docs/DESIGN.md`.

## Constraints found in the current data

- All live page content is stored in the older ACF field `modules` (group "Modules"), but
  this branch's `page.php` and `front-page.php` only render `page_modules`. Activating the
  branch as it is would show empty pages.
- Live reviews use the post type `reviews` (95 posts, URL base `/reviews/`); this branch
  registers `review`.
- Product URLs are `/shop/<slug>/`; city pages are normal pages (`/sydney/` and so on).

Decision: the theme renders both `modules` and `page_modules`, so existing content keeps
working without a data migration, and new or restyled sections use `page_modules`. The
theme registers `reviews` with the same slug, so all 95 reviews and their URLs stay.

## Phases

1. **Foundation.** Colour tokens, self-hosted fonts, header, footer, Theme Settings fields
   (announcement bar, WhatsApp, footer columns, disclaimer, GA ID). Page
   templates render `modules` then `page_modules`.
2. **Keep live behaviour.** Port from the live theme: Medical Conditions checkout section
   (saved to order meta and shown in admin), shipping method delivery-time subtext, live
   product total, review submission form (pending reviews), product price note field,
   PayID and bank logos, `/shop-page` and `/product/` redirects.
3. **Restyle the old layouts in use** (new design, same fields): text_-_full_width, faqs,
   feature_product, feature_product_inline, final_thoughts, city_header,
   location_banner, text_left, text_-_12_&_12, hero_section, product_carousel,
   how_to_order, who_uses, why_buy, reviews_carousel_grid, cta_button, featured_blog,
   review_page, review_form, breadcrumb, contact. Remove hardcoded fallback copy and
   emojis from all of them.
4. **Page types.** Home, shop, single product, 7 city pages, blog index and posts,
   categories, About, FAQs, Contact, Reviews, Track Order, policies, 404, search.
5. **SEO built into the theme.** One H1 per page from the hero field; heading order
   enforced by module levels; Product schema with aggregateRating from the reviews CPT;
   FAQPage schema from the FAQ module; breadcrumbs; alt text required on ACF image fields;
   width, height, srcset and lazy loading on every image; hero image preloaded and not
   lazy.
6. **Speed.** One minified stylesheet, no jQuery on non-WooCommerce pages, scripts
   deferred, GA loaded from Theme Settings after interaction, responsive image sizes,
   WebP through EWWW. Target: Lighthouse mobile 90+ on home, shop, product and a city page.
7. **QA.** Playwright at 320, 390, 768, 1440; SOP checks before each push; Lighthouse
   before and after.

## Content fixes (entered in WP Admin on InstaWP, not in code)

Meta descriptions for the 23 pages without one; shorter titles without emojis; replace
the WordPress placeholder text in the Privacy Policy; H1 fields on Shipping, Refunds,
About, Brisbane and the Waklert guide; remove the `/product-category/shop-armodafinil/`
sitemap entry or the category; fix the dead `www.armodafinil-australia.com.au` link and
the image hotlinked from modafinilaustraliadirect.com; update internal `/product/` links.

## Needs Ken (live server)

LiteSpeed page cache returns `miss` on every request; check the cache settings and
vary rules after go-live.

## Status (2026-10-27, local build on branch issue/7-rename-theme-folder)

Done and checked locally (PHP lint, SOP greps, 16 page types at 320/390/768/1440, product add to cart,
BACS thank you page):

- Foundation: navy and yellow tokens, self-hosted Inter and Poppins, `modules` + `page_modules` rendering,
  `reviews` post type, live URL logic, security.php, menu and logo carry-over.
- Header, footer, search dialog, product card, shop and category templates, single product page, cart,
  checkout (3 steps, medical conditions kept), thank you page, blog index, archives, search, 404.
- The 21 module layouts used on live pages restyled; fallback copy, fake testimonials, placeholder images,
  other-site contact details and hardcoded structured data removed.
- Removed on purpose: passwordless login and the My Account overrides (copy from another site, account
  creation from an email address), email header and footer overrides (other-site branding), an
  `admin_init` routine that could delete plugin folders from a query string, HTML sitemap and
  condition and medical reviewer templates (not on live).

Open items for Bintang and Steven are listed in the hand-over notes of the session report.
