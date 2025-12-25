# Pico JSON CMS

**Pico JSON CMS** is a lightweight, flat-file Content Management System built with PHP and JSON — designed for simplicity, performance, and long-term maintainability.

It is ideal for small websites, low-resource servers, and developers who want full control without databases or heavy frameworks.

---

## 🚀 Current Status

- **Latest Version:** v0.2.0  
- **Previous Release:** v0.1.0-beta  
- **Roadmap:** v1.0.0 (LTS / Core Frozen)

Pico JSON CMS is under active development and transitioning toward a **stable, frozen core** with a plugin-driven architecture.

---

## ✨ Key Features

- 📁 JSON-based storage (no database required)
- 🧩 Plugin system with hooks & filters
- 📝 Markdown content powered by **League CommonMark**
- 🎨 New theme system (layouts, partials, pages)
- 🛠 Web-based installer (first-run setup)
- 🔒 Semi-frozen core architecture (v1.0 goal)
- ⚡ Fast, minimal, and shared-hosting friendly
- 🧠 Clean MVC-inspired structure

---

## ❌ What Was Removed

- ❌ Bulma CSS framework
- ❌ Inline admin.php entry file
- ❌ Hard-coded UI dependencies
- ❌ Parsedown / ParsedownExtra
- ❌ Legacy theme structure

Everything is now **simpler, cleaner, and more maintainable**.

---

## 🧠 Philosophy

Pico JSON CMS follows these principles:

- **Small core**
- **Explicit code**
- **No magic**
- **No database**
- **Long-term stability**

Once v1.0.0 is released, the **core API will be frozen**, ensuring backward compatibility for plugins and themes.

---

## 🧩 Plugin System

Plugins use hooks and filters similar to WordPress, but much lighter:

- `add_action()`
- `add_filter()`
- Lazy loading
- No global pollution

Included by default:
- Markdown rendering (CommonMark)
- Syntax highlighting (Prism.js, optional)

---

## 📝 Markdown Support

Markdown is handled via:

- **league/commonmark**
- CommonMark-compliant
- Extensible
- PHP-8.1+ compatible
- No deprecation warnings

---

## 🎨 Theme System

Themes are fully file-based and structured:

```
themes/default/
├── assets/
│   └── css/
├── layouts/
├── pages/
├── partials/
├── admin/
├── installer/
└── theme.php
```

No framework is enforced — **pure CSS and semantic HTML**.

---

## ⚙️ Installation

### 1️⃣ Download or clone

```bash
git clone https://github.com/almhdy24/pico-json-cms.git
```

### 2️⃣ Upload to your server

Upload the project files to your PHP server (shared hosting is supported).

### 3️⃣ Set permissions

Ensure the `content/` directory is writable:

```bash
chmod -R 755 content/
```

### 4️⃣ Run the installer

Open your browser and visit:

```
http://your-site/install
```

The installer will guide you through:
- System checks
- Admin account creation
- Site configuration

After installation, the installer locks itself automatically.

---

## 🔐 Admin Panel

- Secure login
- Brute-force protection
- Soft delete (trash system)
- Auto cleanup for old trashed posts
- Settings stored in JSON

Admin URL:

```
/admin
```

---

## 📂 Project Structure

```
pico-json-cms/
├── CHANGELOG.md
├── CORE_FREEZE.md
├── composer.json
├── composer.lock
├── config.php
├── content/
│   ├── posts.json
│   └── settings.json
├── controllers/
├── core/
├── models/
├── plugins/
├── themes/
│   └── default/
├── index.php
└── functions.php
```

---

## ⚠️ Limitations

- Single admin user
- Not intended for high-concurrency traffic
- Flat-file storage (JSON)

These are **intentional design choices**.

---

## 🛣 Roadmap

### v0.2.x
- Stabilize installer
- Finalize plugin API
- Improve documentation

### v1.0.0 (LTS)
- Core freeze
- Plugin & theme API locked
- Long-term support
- Backward compatibility guaranteed

---

## 👨‍💻 Author

**Elmahdi Abdallh**  
PHP Backend & CMS Developer  

- GitHub: https://github.com/almhdy24  
- Website: https://pico-json-cms.alwaysdata.net  

---

⭐ If Pico JSON CMS helps you, consider starring the repository.