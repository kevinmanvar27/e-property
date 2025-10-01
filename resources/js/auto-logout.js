// Auto Logout functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get the auto logout timeout from the settings (in minutes)
    const autoLogoutTimeout = window.autoLogoutTimeout || 30;
    
    // Convert minutes to milliseconds
    const timeoutInMilliseconds = autoLogoutTimeout * 60 * 1000;
    
    // Show warning 50 seconds before logout
    const warningTime = 50 * 1000;
    
    // Time user has to respond to warning (10 seconds)
    const responseTime = 10 * 1000;
    
    let inactivityTimer;
    let warningTimer;
    let countdownTimer;
    let countdownElement;
    
    // Function to reset the inactivity timer
    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        clearTimeout(warningTimer);
        hideWarningModal();
        
        // Set timer to show warning
        warningTimer = setTimeout(showWarningModal, timeoutInMilliseconds - warningTime);
    }
    
    // Function to show the warning modal
    function showWarningModal() {
        // Create modal if it doesn't exist
        let modal = document.getElementById('auto-logout-warning');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'auto-logout-warning';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                    <div style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 500px; width: 90%;">
                        <h3 style="margin-top: 0; color: #333;">Session Timeout Warning</h3>
                        <p style="font-size: 16px; color: #666;">Your session will expire due to inactivity.</p>
                        <p style="font-size: 18px; font-weight: bold; color: #e74c3c;">Logging out in <span id="countdown">10</span> seconds</p>
                        <p style="font-size: 14px; color: #999;">Move your mouse or click to continue your session</p>
                        <button id="stay-logged-in" style="background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 15px;">Stay Logged In</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Add event listener to stay logged in button
            document.getElementById('stay-logged-in').addEventListener('click', function() {
                resetInactivityTimer();
            });
        }
        
        // Show the modal
        modal.style.display = 'block';
        
        // Start countdown
        let countdown = 10;
        countdownElement = document.getElementById('countdown');
        countdownElement.textContent = countdown;
        
        countdownTimer = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownTimer);
                logoutUser();
            }
        }, 1000);
    }
    
    // Function to hide the warning modal
    function hideWarningModal() {
        const modal = document.getElementById('auto-logout-warning');
        if (modal) {
            modal.style.display = 'none';
        }
        if (countdownTimer) {
            clearInterval(countdownTimer);
        }
    }
    
    // Function to log out the user
    function logoutUser() {
        hideWarningModal();
        performLogout();
    }
    
    // Function to perform the actual logout
    function performLogout() {
        // Submit the logout form
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.submit();
        } else {
            // Fallback: redirect to logout URL
            window.location.href = '/admin/logout';
        }
    }
    
    // Reset the timer on these events
    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keypress', resetInactivityTimer);
    document.addEventListener('click', resetInactivityTimer);
    document.addEventListener('scroll', resetInactivityTimer);
    document.addEventListener('touchstart', resetInactivityTimer);
    document.addEventListener('touchmove', resetInactivityTimer);
    
    // Initialize the timer
    resetInactivityTimer();
});