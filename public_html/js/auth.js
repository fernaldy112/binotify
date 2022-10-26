document.addEventListener('DOMContentLoaded', _ => {
    /**
     * @type {HTMLButtonElement}
     */
    const signupButton = document.querySelector('.signup-btn');
    /**
     * @type {HTMLButtonElement}
     */
    const loginButton = document.querySelector('.login-btn');

    signupButton.onclick = _ => {
        window.location = '/register';
    };

    loginButton.onclick = _ => {
        window.location = '/login';
    };
});