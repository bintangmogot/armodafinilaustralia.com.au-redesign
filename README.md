# armodafinilaustralia.com.au-redesign

Custom WordPress theme based on Armodafinil Australia Direct. Git tracks theme code only. The repository root maps to `wp-content/themes/armodafinilaustralia.com.au-redesign` in WordPress.

## Setup

Restore the shared UpdraftPlus baseline into your own Laragon site, then clone this repository into the theme directory. Keep wp-config.php, plugins, uploads, and the database outside Git. Activate the theme with ACF Pro and WooCommerce available.

```bash
git clone https://github.com/bintangmogot/armodafinilaustralia.com.au-redesign.git armodafinilaustralia.com.au-redesign
cd armodafinilaustralia.com.au-redesign
git switch dev
npm ci
npm run build
```

## Work with another developer or AI

1. Create or select a GitHub issue with page/module scope, file ownership, and acceptance checks.
2. Create a feature branch from current dev. Different pages can share header, footer, CSS, functions, and ACF fields, so coordinate those files explicitly.
3. Implement, test, commit, and push your branch. Open a PR into dev and link the issue.
4. The other developer reviews the diff and checks. A human merges the PR. InstaWP deploys dev after merge.
5. Enter final page text, products, prices, and media on the shared InstaWP CMS. Do not replace the shared database with a developer's local database after collaboration starts.
6. After client approval, open a separate dev-to-main PR for handover. Production deployment needs separate authorization.

```bash
git fetch origin
git switch -c issue/12-about-page origin/dev
# Make changes and run checks
git add <changed-files>
git commit -m "Improve About page modules"
git push -u origin issue/12-about-page
gh pr create --base dev --title "Improve About page modules" --body "Closes #12"
```

The correct sequence is issue, branch, implementation, checks, commit, push, PR, review, merge. A PR needs a pushed commit first. Never have two people push unrelated work directly to dev.

Example cloud request: "Work on issue #12 from origin/dev. Follow AGENTS.md, keep to the issue's files, run the relevant checks, commit and push a feature branch, and open a PR into dev. Do not merge or change CMS data."

## Cloud and staging

Cloud install command: `bash scripts/cloud-setup.sh`. Cloud checks cover theme syntax and CSS compilation. An actual WordPress runtime requires a separate database and plugins; do not publish the golden backup or licensed plugins in this public repository.

InstaWP Git configuration: repository `https://github.com/bintangmogot/armodafinilaustralia.com.au-redesign.git`, branch `dev`, destination `wp-content/themes/armodafinilaustralia.com.au-redesign`. Register the site's webhook in GitHub with push events. Do not publish webhook URLs or credentials in documentation.

Read AGENTS.md for code and content rules. Existing copied theme behavior still requires the audits listed in GitHub Issues; these are acceptance tasks, not confirmed bugs.
