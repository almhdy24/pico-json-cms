# Plugins in pico-json-cms

**pico-json-cms** comes with a simple but powerful plugin system that allows you to extend functionality without modifying core files. Plugins are PHP scripts placed in the `plugins/` folder and loaded via `config.php`.

---

## How Plugins Work

1. Each plugin is a PHP file in the `plugins/` folder.
2. Plugins are loaded automatically on every page load if listed in `config.php`.
3. Hooks allow your code to interact with the CMS at specific points.

---

## Available Hooks

| Hook Name        | Description                          | Parameters      |
|-----------------|--------------------------------------|----------------|
| `admin_notices`  | Display messages in the admin panel  | None           |
| `post_content`   | Modify or append content to posts    | `$content`     |
| `before_post`    | Execute before rendering a post      | `$post` array  |
| `after_post`     | Execute after rendering a post       | `$post` array  |

---

## Step 1: Configure Plugins

Edit `config.php` to define which plugins to load:

```php
<?php
return [
    'base_url' => '',        // Your site base URL if needed
    'theme' => 'default',    // Theme folder name from 'themes/'
    'plugins' => [
        'markdown-plugin.php',
        'syntax-highlighting.php',
        'pico-notice.php',
        // Add your own plugins here
        'my-custom-plugin.php'
    ]
];
```

> ⚠️ Important: Only plugins listed in the `plugins` array will be loaded. Add plugin filenames exactly as they appear in the `plugins/` folder.

---

## Step 2: Create a Plugin

1. Create a new PHP file in `plugins/`, for example:

```
plugins/my-custom-plugin.php
```

2. Add hooks using `do_action()`:

```php
<?php
// Example: Append a footer to every post
do_action('post_content', function($content) {
    return $content . '<hr><p style="font-size:12px; color:#999;">Custom footer added by my plugin.</p>';
});

// Example: Show a notice in admin dashboard
do_action('admin_notices', function() {
    echo '<div style="background:#d4edda; padding:10px; margin:10px 0; border-left:4px solid #28a745;">
        My plugin is active
    </div>';
});
?>
```

---

## Step 3: Plugin Best Practices

- **One plugin = one feature:** Keep your plugins small and modular.  
- **Descriptive names:** Avoid conflicts by using clear plugin filenames.  
- **Backup first:** Always backup `config.php` and the `plugins/` folder before adding new plugins.  
- **Test locally:** Use a local PHP server (`php -S localhost:8000`) to test before deploying.  

---

## Step 4: Future Enhancements

- A **plugin installer in the admin panel** is planned, allowing enabling/disabling plugins without editing `config.php`.  
- Themes will also be manageable via admin panel soon.  
- This modular approach ensures that your core CMS remains upgrade-safe while allowing flexible customization.

---

## Examples of Useful Plugins

### Markdown Support

```php
<?php
do_action('post_content', function($content) {
    // Convert Markdown to HTML using Parsedown
    $Parsedown = new Parsedown();
    return $Parsedown->text($content);
});
?>
```

### Syntax Highlighting

```php
<?php
do_action('post_content', function($content) {
    // Wrap <pre> blocks with syntax highlighting classes
    return preg_replace_callback('/<pre><code>(.*?)<\/code><\/pre>/s', function($matches) {
        return '<pre class="hljs">' . htmlspecialchars($matches[1]) . '</pre>';
    }, $content);
});
?>
```

---

## Summary

1. **Add plugin files** to the `plugins/` folder.  
2. **List plugins** in `config.php`.  
3. **Use hooks** (`do_action`) to interact with posts, admin notices, and more.  
4. **Test & backup** before deploying.  
5. **Future:** Admin panel plugin installer and theme management will make customization even easier.  

This system makes **pico-json-cms** lightweight, modular, and developer-friendly.