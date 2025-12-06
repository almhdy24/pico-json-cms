# Complete Guide

## Installation

### Option 1: Manual Download
1. Download the ZIP from GitHub: [almhdy24/pico-json-cms](https://github.com/almhdy24/pico-json-cms)
2. Extract the files into your web server folder
3. Done! Your site files are ready.

### Option 2: Git
```bash
git clone https://github.com/almhdy24/pico-json-cms.git
cd pico-json-cms
```

### Composer Dependencies

pico-json-cms uses **Parsedown** to render Markdown posts. Install dependencies with Composer:

```bash
composer install
```

This will create the `vendor/` folder and load Parsedown automatically.

### First Run

1. Open your site in a browser (e.g., `http://localhost/pico-json-cms/` or your domain)
2. Sample posts will appear if included
3. Go to `/admin/login`
4. Login with the default credentials: `admin / secret123`

⚠️ **Important:** Change the default password immediately in `admin.php`:

```php
// Replace 'secret123' with your strong password:
$admin_password_hash = password_hash('your-strong-password', PASSWORD_DEFAULT);
```

### File Structure

```
pico-json-cms/
├── README.md
├── admin.php
├── assets/
│   ├── bulma.min.css
│   ├── easymde.min.css
│   └── easymde.min.js
├── composer.json
├── composer.lock
├── config.php
├── content/
│   ├── posts.json
│   └── settings.json
├── controllers/
│   ├── AdminController.php
│   └── HomeController.php
├── core/
│   ├── App.php
│   ├── Auth.php
│   ├── Controller.php
│   ├── Hooks.php
│   ├── Model.php
│   ├── Router.php
│   └── View.php
├── docs/
├── functions.php
├── index.php
├── models/
│   ├── PostsModel.php
│   └── SettingsModel.php
└── plugins/
    ├── markdown-plugin.php
    └── syntax-highlighting.php
```

### Creating Your First Post

1. Login to the admin panel (`/admin/login`)
2. Click **Add New Post**
3. Fill in:
   - **Title** (required)
   - **Slug** (auto-generated, editable)
   - **Content** (supports **HTML** and **Markdown** if plugin enabled)
4. Click **Save** → Post is live at `/post/your-slug`

### Site Settings

Edit `content/settings.json` directly or via the admin panel:

```json
{
  "site_title": "My Awesome Site",
  "site_description": "A simple blog powered by pico-json-cms",
  "posts_per_page": 5
}
```

### Deployment Tips

**Local Development:**

```bash
php -S localhost:8000
```

**Shared Hosting / AlwaysData:**

1. Upload all files via FTP/SFTP or Git
2. Ensure `content/` folder is writable (permissions `755` or `775`)
3. Visit your domain → CMS is ready

### Notes

- Markdown content is rendered via `Parsedown`
- To use Markdown in posts, simply write your content using `.md` syntax in the post editor
- Existing HTML posts continue to work