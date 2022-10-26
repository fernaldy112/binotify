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

    signupButton.onclick = _ => {
        window.location = '/register';
    };

    loginButton.onclick = _ => {
        window.location = '/login';
    };

    logoutButton.onclick = _ => {
    //    TODO: handle logout
    };
});