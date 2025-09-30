// Suppress common browser extension errors
(function() {
    // Store original console.error
    const originalError = console.error;
    
    // Override console.error to filter out known extension errors
    console.error = function() {
        const args = Array.from(arguments);
        const message = args[0];
        
        // Check if this is a known extension error we want to suppress
        if (typeof message === 'string') {
            // Suppress chrome-extension errors
            if (message.includes('chrome-extension://') || 
                message.includes('extension') ||
                message.includes('content.js') ||
                message.includes('contentScript.bundle.js') ||
                message.includes('toolsrise.com')) {
                return; // Don't log these errors
            }
            
            // Suppress PerfectScrollbar errors for missing elements
            if (message.includes('no element is specified to initialize PerfectScrollbar')) {
                return; // Don't log these errors
            }
        }
        
        // For all other errors, call the original console.error
        originalError.apply(console, arguments);
    };
    
    // Also suppress unhandled promise rejections from extensions
    window.addEventListener('unhandledrejection', function(event) {
        if (event.reason && typeof event.reason === 'string') {
            if (event.reason.includes('chrome-extension') || 
                event.reason.includes('extension') ||
                event.reason.includes('content.js') ||
                event.reason.includes('contentScript.bundle.js')) {
                event.preventDefault(); // Prevent these from showing in console
            }
        }
    });
})();