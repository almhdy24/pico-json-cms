<?php
/*
Plugin Name: System Info Notice
Description: Shows useful system information and CMS version in the admin panel.
*/

do_action('admin_notices', function() {
    $phpVersion = phpversion();
    $cmsVersion = 'v1.0.0'; // update if versioning is added
    $maxUpload = ini_get('upload_max_filesize');
    $memoryLimit = ini_get('memory_limit');

    $warnings = [];
    if (version_compare($phpVersion, '7.4', '<')) {
        $warnings[] = "PHP version is below 7.4 – upgrade recommended!";
    }
    if (!is_writable(__DIR__ . '/../content')) {
        $warnings[] = "Content folder is not writable!";
    }

    echo '<div style="background:#fff3cd; color:#856404; padding:15px; border-left:4px solid #ffc107; margin-bottom:15px; border-radius:6px;">';
    echo "<strong>System Info:</strong><br>";
    echo "PHP Version: $phpVersion<br>";
    echo "CMS Version: $cmsVersion<br>";
    echo "Max Upload Size: $maxUpload<br>";
    echo "Memory Limit: $memoryLimit<br>";

    if ($warnings) {
        echo "<strong>Warnings:</strong><br>";
        foreach ($warnings as $w) {
            echo "⚠️ $w<br>";
        }
    }

    echo '</div>';
});