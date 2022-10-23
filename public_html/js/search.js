document.addEventListener('DOMContentLoaded', _ => {
    const table = new TableRenderer('.search-result');

    table.change(result, page);
})