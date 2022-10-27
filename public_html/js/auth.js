document.addEventListener('DOMContentLoaded', _ => {
    /**
     * @type {HTMLButtonElement}
     */
    const signupButton = document.querySelector('.signup-btn');
    /**
     * @type {HTMLButtonElement}
     */
    const loginButton = document.querySelector('.login-btn');
    /**
     * @type {HTMLButtonElement}
     */
    const logoutButton = document.querySelector('.logout-btn');

    if (signupButton) {
        signupButton.onclick = _ => {
            window.location = '/register';
        };
    }

    if (loginButton) {
        loginButton.onclick = _ => {
            window.location = '/login';
        };
    }

    if (logoutButton) {
        logoutButton.onclick = _ => {
            window.location = '/logout';
        };
    }
});