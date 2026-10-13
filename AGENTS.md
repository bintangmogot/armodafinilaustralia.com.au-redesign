# Project instructions

This repository contains only the custom WordPress theme for the `armodafinilaustralia.com.au-redesign` project, based on Armodafinil Direct. The current stack is PHP, ACF Pro, WooCommerce, and Tailwind CSS 3. Do not rebuild it as a React application.

## Content and code

- Keep page copy, headings, images, prices, contact information, and badges editable in WordPress/ACF. Do not add editorial text to PHP templates.
- Use existing theme tokens, modules, hooks, and WooCommerce overrides. Never edit WordPress core or plugin files.
- Do not include credentials, license keys, database dumps, orders, customer records, backups, uploads, or paid plugins in Git.
- The inherited WORDPRESS-MIGRATION-GUIDE.md describes a different Malaysia prototype. It is not the requirements document for this project. Use these instructions and the current issue instead.
- Use plain copy without emojis, em dashes, en dashes, or exaggerated claims. Do not invent medical, delivery, pricing, or policy statements.

## Issue to pull request workflow

1. Read the issue and its acceptance checks. Create an issue for substantial requested work if none exists. Do not invent requirements or claim audit findings before checking them.
2. Fetch `origin/dev` and create `issue/<number>-<short-description>` from it. Keep one issue and one developer or AI responsible for a branch.
3. State the files you own in the issue/PR. Coordinate edits to shared files such as functions.php, input.css, style.css, and ACF JSON. Preserve other developers' work.
4. Implement and validate the smallest coherent change. Run `npm ci`, `npm run build` when styles change, and PHP syntax checks for changed PHP files. Commit generated style.css with input.css changes.
5. Review the full diff for scope and secrets. Commit with a clear imperative subject, push the feature branch, then open a PR targeting `dev` with `Closes #<number>` and actual verification evidence.
6. Do not merge, post external PR comments, deploy, modify staging content, restore databases, or change production without explicit user authorization. Repository push/PR creation is permitted when the task asks for the issue-to-PR workflow.

`dev` is the shared InstaWP staging branch. `main` is the approved handover branch. A push to a feature branch must not deploy. Human review and merge to dev promotes the change to staging. Promote dev to main only after client approval and explicit authorization.

## Verification

- `npm run build`: compile Tailwind CSS.
- PHP syntax: `find . -name '*.php' -not -path './node_modules/*' -print0 | xargs -0 -n1 php -l` on Linux.
- GitHub Actions runs PHP syntax and stylesheet build checks for PRs and pushes.
- Cloud theme checks do not prove WordPress behavior. Full plugin/database context remains in local Laragon and InstaWP. Use staging for ACF rendering, variation selection, cart, checkout, forms, and responsive QA, and report unverified behavior accurately.

Final copy, product data, and media belong in the shared InstaWP CMS. Git deploys theme code only. Full-site restoration is a separate operation.

