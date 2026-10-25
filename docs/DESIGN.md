# Armodafinil Australia Design System

Direction: **clinical commerce, navy and yellow**. The colours stay the same as the
current live site (October 2026 client decision). Layout follows four reference sites from
the same client network:

- modafinil-malaysia.com and modafinilperth.com: announcement bar, sticky header with a
  WhatsApp button, full-bleed hero with a photo under a colour overlay, stat chips, three
  order steps, "who uses it" grid, product cards, delivery block, comparison table,
  reviews, FAQ, closing CTA band, dark footer.
- buyivermectinaustralia.com: buy box in the hero (quantity buttons, price, add to cart),
  stats band, "explore by condition" links, sources and references block.
- ozmodafinil.com: packaging trust strip, price guarantee bar, city links block.

Principles

1. **One action colour.** Yellow is only for the main buy action. Navy carries headings,
   links, dark bands and the footer. Everything else is white, one light blue tint and grey.
2. **Products early.** The hero buy box and the product grid sit above the fold on desktop
   and within two screens on mobile.
3. **Flat and quiet.** 1px borders, no glows, no gradients on content, no dot or grid
   textures, no emojis, no animated pings (see `.agents/persona.md`).
4. **Every visible word comes from ACF or WooCommerce.** Templates only lay out fields.
5. **Fast by default.** One stylesheet, self-hosted fonts, responsive images, no carousel
   libraries above the fold.

## Colour tokens (`input.css` `:root`, HSL for Tailwind)

| Token | Hex | Role |
|---|---|---|
| `--primary` | `#00125E` | Headings, links, dark bands, footer |
| `--primary-light` | `#073980` | Hero overlay, hover on navy |
| `--secondary` | `#1B4F93` | Icons, secondary buttons |
| `--accent` | `#FFD000` | Main buy button, price highlight (navy text on it) |
| `--accent-hover` | `#E6BB00` | Buy button hover |
| `--surface` | `#EAF2FF` | Tinted sections, image wells, chips |
| `--surface-strong` | `#E1EDFF` | Cards on tinted sections |
| `--foreground` | `#0F172A` | Body text |
| `--muted-foreground` | `#475569` | Secondary text |
| `--border` | `#DCE5F2` | Hairlines |
| `--star` | `#F5B400` | Star ratings only |
| `--success` | `#15803D` | In stock, ticks |

Contrast: navy on white 16:1, navy on yellow 12:1, white on navy 16:1. Never white text on
yellow.

## Typography

- Headings: **Poppins** 600/700. Body and UI: **Inter** 400/500/600. Both self-hosted
  (woff2, latin subset, `font-display: swap`, heading weight preloaded).
- Scale: H1 `clamp(2.25rem, 1.6rem + 3vw, 3.75rem)` / 1.1; H2 `clamp(1.75rem, 1.3rem + 2vw,
  2.75rem)` / 1.15; H3 1.25-1.5rem; body 16-17px / 1.65; badge 12px uppercase 0.12em.
- One H1 per page, always from the page's hero field. Module titles are H2, cards H3.

## Layout

- Container max 1240px, 16px gutter on phones, 24px tablet, 32px desktop.
- Section padding `py-14 md:py-20`. Alternate white and `--surface` backgrounds.
- Section header: badge chip, H2, short lead, centred, max 720px.

## Components

- Announcement bar (navy, one line, from Theme Settings).
- Header: logo left, nav centre, WhatsApp button and cart right; sticky with a white
  background and bottom border after scroll. Mobile: drawer menu.
- Hero: navy overlay on an ACF image, H1, lead, two buttons, three stat chips; desktop
  right column is the buy box for one ACF-selected product.
- Buy box / product card: image on tint, name, stars with review count, "from" price and
  per-tab price, 2-column quantity buttons (`rounded-lg`) that update the price,
  `Choose Quantity (prices in AUD)`, full-width yellow button.
- Steps, audience grid, comparison table, trust strip, city links, reviews, two-column
  FAQ, CTA band, sources block: as listed in the module map in `docs/REDESIGN-PLAN.md`.
- Footer: navy, columns Shop, Trending Products, Help, Company, Areas Delivered in
  Australia; payment logos; medical disclaimer. No third-party review badges (client decision).

## Motion

Colour, opacity and transform transitions only, 150-200ms. Respect
`prefers-reduced-motion`.
