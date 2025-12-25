# Changelog

All notable changes to **Pico JSON CMS** will be documented in this file.

The format is based on *Keep a Changelog*  
and this project follows *Semantic Versioning*.

---

## [0.2.0] – 2025-01-XX

### 🚀 Major Update – Architecture & Stability

This release is a **large internal refactor** focused on long-term stability, clarity, and extensibility.  
It prepares Pico JSON CMS for a future **v1.0.0 stable release**.

---

### ✨ Added

- Interactive **web installer**
  - System requirements check
  - Admin account creation
  - Site settings initialization
  - Installation lock file (`content/.installed`)
- **Frozen Core API**
  - Core classes marked as stable
  - Public APIs documented and locked
  - `CORE_FREEZE.md` introduced
- New **plugin system**
  - Plugin loader
  - Hooks & filters architecture
  - Markdown and syntax highlighting now plugin-based
- **League CommonMark** integration
  - Replaced Parsedown / ParsedownExtra
  - Modern, actively maintained Markdown parser
  - Better standards compliance
- System information page (Admin → System)
- Trash management
  - Soft delete
  - Restore posts
  - Auto-cleanup after defined days
- Pagination improvements (admin & frontend)
- Installer safety checks and rollback handling

---

### 🔧 Changed

- Rewritten **theme system**
  - Clear separation:
    - layouts
    - pages
    - partials
    - assets
  - Installer templates isolated from site theme
- Removed **Bulma CSS**
  - Fully custom, lightweight CSS
  - No external CSS framework dependency
- Controllers refactored and **semi-frozen**
  - Cleaner responsibilities
  - Safer routing
  - Improved validation
- Models refactored
  - Atomic JSON writes
  - Safer file handling
  - Clear read/write separation
- Router enhanced
  - Safer dispatch logic
  - Better error handling
- Markdown rendering pipeline updated
- Admin authentication hardened
  - Login throttling
  - Session regeneration
  - Improved guards

---

### 🗑 Removed

- Bulma CSS
- EasyMDE assets
- Parsedown / ParsedownExtra
- Old theme structure
- Legacy admin entry files
- Temporary documentation (docs removed temporarily)

---

### 🐛 Fixed

- Admin pagination redirecting to frontend
- Settings not saving during installation
- Float offsets in pagination (`array_slice` error)
- Slug duplication edge cases
- Trash cleanup inconsistencies
- Markdown rendering warnings (PHP 8.1+)

---

### 🔐 Security

- Admin credentials stored outside public root
- Installer disabled after completion
- Atomic writes for all JSON data
- Reduced surface area in core classes

---

### 🧱 Internal

- Added `CORE_FREEZE.md`
- Improved inline documentation
- Cleaner namespaces and imports
- Better separation between Core / App / Plugins

---

### ⚠️ Notes

- This is still a **pre-1.0 release**
- Public APIs introduced here are intended to remain stable
- Documentation will be reintroduced in a later release

---

## [0.1.0-beta] – 2024-12-XX

- Initial public beta release
- JSON-based CMS core
- Basic admin panel
- Simple theme support
- Parsedown Markdown support

---

## Roadmap

- v1.0.0 Stable
  - Full documentation
  - Upgrade guide
  - Plugin API freeze
  - Long-term support branch

---