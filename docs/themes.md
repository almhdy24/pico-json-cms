# Themes

Templates in `themes/` control both the **front-end** and **admin panel** appearance.

Your default theme structure:

```
themes/
└── default/
    ├── admin.php           # Admin panel base wrapper
    ├── admin_add.php       # Add post page
    ├── admin_edit.php      # Edit post page
    ├── admin_layout.php    # Admin layout wrapper
    ├── admin_login.php     # Admin login page
    ├── base.php            # Front-end base template
    ├── dashboard.php       # Admin dashboard page
    ├── index.php           # Homepage template
    ├── settings.php        # Admin settings page
    ├── single.php          # Single post template
    └── style.css           # Theme CSS
```

---

## How to Customize

### Front-End

1. **Base Template**  
   `base.php` wraps your front-end pages. Edit it to change:
   - Header/footer layout
   - Navbar
   - Footer text

2. **Homepage & Post Templates**  
   - `index.php` – homepage posts list  
   - `single.php` – individual post page  
   Edit the HTML/CSS here to change post layouts.

3. **Style**  
   - `style.css` – main stylesheet. Change colors, fonts, spacing, or add responsive tweaks.

---

### Admin Panel

The admin templates are in the same theme folder for flexibility:

- `admin.php` – main admin wrapper  
- `admin_layout.php` – layout structure for admin pages  
- `dashboard.php` – dashboard overview  
- `admin_login.php` – login page  
- `admin_add.php` / `admin_edit.php` – add/edit post forms  
- `settings.php` – site settings page  

You can modify these templates to change the admin panel UI without touching core logic.

---

## Creating a New Theme

1. Copy the `default` folder:

```
cp -r themes/default themes/mytheme
```

2. Update templates & CSS in `themes/mytheme/`
3. Switch the theme in `config.php`:

```
$theme = 'mytheme';
```

4. Reload site to see changes.

---

### Tips

- Always backup before editing.
- Keep admin templates in sync to avoid breaking functionality.
- Use relative paths in CSS/JS.
- Test both front-end and admin on mobile.

---

Next → [Plugins](plugins.md)