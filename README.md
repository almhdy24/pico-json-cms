# Pico JSON CMS

**Live Demo:** [http://pico-json-cms.alwaysdata.net/](http://pico-json-cms.alwaysdata.net/)

---

## Introduction

Pico JSON CMS is a lightweight JSON-based CMS with Markdown support. It allows you to:

- Create, edit, and delete posts
- Manage site settings
- Extend the system with **themes** and **plugins**
- Designed for developers: full control, easy customization

---

## Installation

1. Clone the repository:
```
git clone git@github.com:almhdy24/pico-json-cms.git
```

2. Navigate to the folder:
```
cd pico-json-cms
```

3. Install dependencies:
```
composer install
```

4. Make the `content/` folder writable:
```
chmod -R 775 content/
```

---

## Admin Login

- URL: `/admin/login`
- Default credentials are in `admin.php`
- Only admins can access `/admin/*` pages

---

## Creating Posts

- Go to `/admin/add` to create a post
- Use **Markdown** for styling
- Posts are stored in `content/posts.json`

### Example Markdown
```
# My First Post
Hello, this is **bold** and *italic* text.

- Bullet point
- Another bullet
```

---

## Themes

- Themes are located in `/themes`
- To create a new theme:
  1. Copy the `default/` folder
  2. Rename it
  3. Edit `index.php`, `base.php`, `admin_layout.php`
  4. Update CSS or JS for custom styling

- Activate a theme by editing `config.php`:
```
'theme' => 'mytheme'
```

---

## Plugins

- Plugins live in `/plugins`
- They can modify posts, settings, or add hooks
- Example plugin: `hello-plugin.php`
```
<?php
add_filter('post_content', function($content) {
    return $content . "\n\n*Powered by Pico JSON CMS*";
});
```

- Syntax Highlighting plugin example:
```
<?php
add_filter('post_content', function($content) {
    $highlighted = preg_replace('/```(.*?)\n(.*?)```/s', '<pre><code class="$1">$2</code></pre>', $content);
    return $highlighted;
});
```

---

## Markdown Tips

- `# H1`, `## H2`, `### H3` for headings
- `**bold**` for bold
- `*italic*` for italic
- `- list item` for unordered lists
- `[link](https://example.com)` for links

---

## User Roles

- **Admin**: Full access
- **Normal User**: View-only

---

## Publishing Your Work

- Add posts using admin panel
- Markdown formatting will render automatically
- Make `content/` writable
- Developers can create themes or plugins to extend functionality

**Live Site:** [http://pico-json-cms.alwaysdata.net/](http://pico-json-cms.alwaysdata.net/)

---

## Developer Hooks & Extending CMS

- **Actions**: Use `add_action('hook_name', callback)` to run code at certain points
- **Filters**: Use `add_filter('hook_name', callback)` to modify data
- Example:
```
<?php
add_filter('post_content', function($content) {
    return $content . "\n\n*Footer added via plugin*";
});
```
- Plugins are loaded automatically from `/plugins` folder

---

## Example Posts on Live Demo

- Welcome to Pico JSON CMS
- Getting Started
- Creating a New Post
- Themes in Pico JSON CMS
- Plugins in Pico JSON CMS
- Admin Panel Overview
- Markdown Styling Tips
- User Permissions
- Managing Settings
- Publishing Your Work