<?php
add_action('beforeRender', function($view, $data){
    echo "<div class='notification is-info'>Welcome to Pico-JSON CMS!</div>";
});

// Example filter: append a footer to every post content
add_filter('post_content', function($content, $post){
    return $content . "<p><em>— Thank you for reading!</em></p>";
});