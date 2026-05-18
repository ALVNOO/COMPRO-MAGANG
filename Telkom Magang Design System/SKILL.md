---
name: telkom-magang-design
description: Use this skill to generate well-branded interfaces and assets for the PT Telkom Indonesia internship management system ("Sistem Penerimaan Magang"), either for production work or throwaway prototypes/mocks/decks. Contains essential design guidelines, colors, type, fonts, assets, and UI kit components for prototyping.
user-invocable: true
---

Read the `README.md` file at the root of this skill first — it contains the brand context, content fundamentals, visual foundations, and iconography rules. Then explore the other files:

- `colors_and_type.css` — drop-in stylesheet with all design tokens and base element styles. Always link this rather than re-defining tokens.
- `assets/logos/` — Telkom Indonesia logos (full lockup + standalone mark).
- `preview/` — small HTML preview cards demonstrating each token group and component. Read these to see exact usage.
- `ui_kits/web-app/` — pixel-faithful React/JSX recreation of the dashboard and auth screens. Copy components from here when building new screens.
- `reference/css/` and `reference/views/` — original Laravel/Blade source from the codebase. Use as ground truth for any pattern you can't find in the UI kit.

When creating visual artifacts (slides, mocks, throwaway prototypes), copy the needed assets out of this skill folder and produce static HTML files for the user. When working on the production Laravel codebase, the tokens in `colors_and_type.css` map 1:1 to the live `resources/css/design-system.css` — apply the rules here directly.

If the user invokes this skill without other guidance, ask what they want to build (a new screen? a marketing page? a deck for an internal review?), confirm they want Telkom Magang branding (vs. a generic dashboard), then act as an expert designer who outputs HTML artifacts or production-ready Blade markup, depending on the need.

Hard rules — never break these:

1. Copy is in **Indonesian**. Use formal `Anda` (capitalized). No `kamu`.
2. **Never use emoji.** Icons come from Font Awesome 6 solid.
3. Telkom red `#EE2E24` is the **only** hero color. Don't introduce blues, purples, or new accents — semantic colors (success/warning/danger/info) are the only exception.
4. Inter only. No serifs, no display fonts.
5. Primary buttons get the colored shadow `0 4px 14px rgba(238,46,36,.25)`. This is the system's signature elevation move.
6. Anything Pos Indonesia (`POSiND`, navy/orange lockup, Pos HQ photography) is a leftover from the project's pre-rebrand history and **never** belongs in a Telkom Magang artifact.
