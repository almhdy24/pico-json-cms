<?php
// themes/default/theme.php

Hooks::add_action('head', function () {
    echo '<meta name="theme" content="default">';
});

Hooks::add_action('admin_dashboard_widgets', function () {
    echo '<div class="box">Demo widget</div>';
});