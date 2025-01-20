<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());
?>
<script>
// Disable right click
document.addEventListener('contextmenu', e => e.preventDefault());

document.addEventListener('DOMContentLoaded', () => {
    // Disable right click with better performance
    document.addEventListener('contextmenu', e => e.preventDefault(), {
        passive: true
    });

    // Optimize keyboard event listener
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
            (e.ctrlKey && e.key === 'u') ||
            (e.ctrlKey && e.key === 'U') ||
            (e.key === 'F12')) {
            e.preventDefault();
        }
    }, {
        passive: false
    });

    // More efficient DevTools detection
    let devToolsCheck = () => {
        const threshold = 160;
        const widthThreshold = window.outerWidth - window.innerWidth > threshold;
        const heightThreshold = window.outerHeight - window.innerHeight > threshold;
        if (widthThreshold || heightThreshold) {
            window.location.reload();
        }
    };
    setInterval(devToolsCheck, 1000);
});
</script>