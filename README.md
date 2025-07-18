# Social Profile Links for WordPress

A lightweight WordPress plugin that allows users to add and display their social media profile links on the front end of the website. This plugin is simple, modular, and built for clean integration without additional styling or options.

## 🔧 Features

- Adds social profile fields to WordPress user profiles.
- Supports multiple popular social media platforms (Facebook, X/Twitter, LinkedIn, Instagram, YouTube, TikTok, Donate, Linktree, Website).
- Automatically displays links on the front-end using a template part or shortcode.
- Clean code structure for easy customization.
- Safe and efficient – follows WordPress coding standards.
- Supports the filter hook `social_profile_links_platforms` for extending or modifying the platform list.

## 🚀 Installation

1. Download or clone this repository.
2. Upload the plugin folder to your WordPress site's `/wp-content/plugins/` directory.
3. Activate the plugin via the WordPress admin dashboard.
4. Edit your user profile and add social media links.
5. Use the included display function or shortcode to render links on the front-end.

## 📁 Folder Structure

```bash
social-profile-links/
├── assets/
│   └── icons/
├── inc/
│   └── social-profile-links-display.php
├── index.php
├── social-profile-link.php
├── uninstall.php
```

## 🛡️ Security & Performance

- Uses `esc_url()`, `esc_html()`, and other WordPress sanitizers.
- Verifies input types before processing form data.
- Efficient `uninstall.php` with batched deletion to prevent memory issues.

## 📌 Example Usage

### 1. Using the global function

You can display the social profile links using the global function:

```php
<?php if ( function_exists( 'get_social_profile_links' ) ): ?>
    <h2 class="font-bold">Follow Me</h2>
    <?php echo get_social_profile_links(); ?>
<?php endif; ?>
```

### 2. For a specific user

```php
$user_id = 123;
echo get_social_profile_links( $user_id );
```

### 3. In the loop

```php
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $author_id = get_the_author_meta( 'ID' );
    echo get_social_profile_links( $author_id );
endwhile; endif;
```

### 4. As a shortcode

Use `[social_profile_links]` inside your posts or pages.  
Optionally, you can specify a user ID: `[social_profile_links user_id="123"]`

## 🎨 Customize with CSS

You can style the social links output by targeting these CSS selectors:

```css
.spl-container      /* Wrapper for the social links list */
.spl-container li   /* Each list item */
.spl-container a    /* The anchor link */
.spl-img            /* The social icon image */
```

Example:

```css
.spl-container {
  display: flex;
  gap: 10px;
  margin-top: 1rem;
}

.spl-container a {
  display: inline-block;
  border-radius: 50%;
  overflow: hidden;
  width: 40px;
  height: 40px;
  transition: transform 0.2s;
}

.spl-container a:hover {
  transform: scale(1.1);
}
```

## 🧩 Extending Platforms

You can customize the social media platforms using the `social_profile_links_platforms` filter:

```php
add_filter( 'social_profile_links_platforms', function( $platforms ) {
    $platforms['mastodon'] = __( 'Mastodon', 'social-profile-links' );
    $platforms['threads'] = __( 'Threads', 'social-profile-links' );
    return $platforms;
});
```

## ❓ FAQ

**Q: Will this plugin affect my site's styling?**  
A: No. It doesn't include any CSS. You can style the output yourself.

**Q: Can I customize the social media platforms?**  
A: Yes! Use the `social_profile_links_platforms` filter to extend or modify the list.

## 🤝 Credits

This plugin is a simplified fork of [Claudio Sanches's Author Bio Box](https://github.com/claudiosanches/author-bio-box) — rebuilt for minimal and clean use.

Icons from [Bootstrap](https://icons.getbootstrap.com/)

## 📄 License

MIT License.