document.addEventListener('DOMContentLoaded', _ => {
    const clearButton = document.querySelector('.search-cancel-btn');
    /**
     * @type {HTMLInputElement}
     */
    const searchBar = document.querySelector('.search-bar');
    /**
     * @type {HTMLFormElement}
     */
    const searchForm = document.querySelector('#search-form');

    function onSearchBarChanged(_) {
        if (searchBar.value) {
            clearButton.removeAttribute('hidden');
        } else {
            clearButton.setAttribute('hidden', '');
        }
    }

    function hide() {
        clearButton.setAttribute('hidden', '');
    }

    searchBar.addEventListener('input', onSearchBarChanged);
    searchBar.addEventListener('invalid', e => {
        e.preventDefault();
    })
    searchForm.addEventListener('reset', hide);
});