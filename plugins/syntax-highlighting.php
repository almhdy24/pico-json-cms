<?php
/**
 * Syntax Highlighting with Prism.js
 */

// Transform Markdown code blocks
add_filter('post_content', function($content) {
    return preg_replace_callback('/```(\w+)\n(.*?)```/s', function($matches) {
        $lang = htmlspecialchars($matches[1]);
        $code = htmlspecialchars($matches[2]);
        return "<pre><code class=\"language-$lang\">$code</code></pre>";
    }, $content);
});

// Inject Prism CSS/JS in head and footer
add_action('head', function() {
    echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">';
});

add_action('footer', function() {
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>';
});