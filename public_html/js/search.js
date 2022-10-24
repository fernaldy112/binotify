document.addEventListener('DOMContentLoaded', _ => {
    const table = new TableRenderer('.result-table');

    table.change(result, page);
    table.registerGenres(genres);
})