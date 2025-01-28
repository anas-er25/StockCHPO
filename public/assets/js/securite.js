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
