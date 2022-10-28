class TableRenderer {

    constructor(selector) {
        this.parent = document.querySelector(selector);
        this.data = {};

        this.hasNext = false;
        this.hasPrev = false;

        this.nextButtons = [];
        this.prevButtons = [];

        this._initOrder();

        this._createHead();
        this._createContent();

        if (this.titleOrder) {
            this.titleCell.classList.add(this.titleOrder.toLowerCase());
        } else {
            this.yearCell.classList.add(this.yearOrder.toLowerCase());
        }
    }

    _initOrder() {
        const params = new URLSearchParams(window.location.search);

        this.titleOrder = null;
        this.titleCell = null;
        this.yearOrder = null;
        this.yearCell = null;

        if (!params.has('s')) {
            this.titleOrder = 'ASCENDING';
            return;
        }

        let order = 'ASCENDING';
        if (params.get('o') === 'desc') {
            order = 'DESCENDING';
        }

        if (params.get('s') === 'title') {
            this.titleOrder = order;
        } else {
            this.yearOrder = order;
        }
    }

    _createHead() {
        const head = document.createElement('tr');
        head.classList.add('head');
        head.appendChild(this._createHeadCell('#'));

        this.titleCell = this._createClickableHeadCell('TITLE', this._sortByTitle.bind(this));
        head.appendChild(this.titleCell);

        head.appendChild(this._createHeadCell('ARTIST'));
        head.appendChild(this._createHeadCell('GENRE'));
        head.appendChild(this._createHeadCell('ALBUM'));

        this.yearCell = this._createClickableHeadCell('PUBLISHED YEAR', this._sortByYear.bind(this));
        head.appendChild(this.yearCell);

        head.appendChild(this._createHeadCell('LENGTH'));
        this.head = head;
    }

    _createClickableHeadCell(text, onClick) {
        const cell = this._createHeadCell(text);
        cell.addEventListener('click', onClick);
        cell.classList.add('sortable');
        return cell;
    }

    _createHeadCell(text) {
        const cell = document.createElement('th');
        cell.textContent = text;
        return cell;
    }

    _createContent() {
        this._createFilterBar();
        this.controlsUpper = this._createControls();
        this.controlsLower = this._createControls();
        this.table = document.createElement('table');

        this.parent.appendChild(this.controlsUpper);
        this.parent.appendChild(this.table);
        this.parent.appendChild(this.controlsLower);
    }

    _createFilterBar() {
        const bar = document.createElement('div');
        bar.classList.add('table-filter-bar');
        this.parent.appendChild(bar);
        this.filterBar = bar;
    }

    _createControls() {
        const controls = document.createElement('div');
        const separator = document.createElement('div');
        separator.classList.add('separator');
        controls.classList.add('table-controls');
        controls.appendChild(this._createPrevButton());
        controls.appendChild(separator);
        controls.appendChild(this._createNextButton());
        return controls;
    }

    _createNextButton() {
        const button = this._createButton('navigate_next');
        this.nextButtons.push(button);
        button.addEventListener('click', this.next.bind(this));
        return button;

    }

    _createPrevButton() {
        const button = this._createButton('navigate_before');
        this.prevButtons.push(button);
        button.addEventListener('click', this.prev.bind(this));
        return button;
    }

    _createButton(text) {
        const button = document.createElement('button');
        button.textContent = text;
        button.classList.add('material-symbols-rounded');
        button.classList.add('table-button');
        return button;
    }

    /**
     *
     * @param {string[]} genres
     */
    registerGenres(genres) {
        const param = new URLSearchParams(location.search);
        const genre = param.get('g');

        this.genreBoxes = [];

        let order = 0;

        const genreDropdownContainer = document.createElement('div');
        genreDropdownContainer.classList.add('genre-dropdown-container');
        this.filterBar.appendChild(genreDropdownContainer);

        const select = document.createElement('div');
        select.name = 'genre';
        select.classList.add('genre-dropdown');
        select.innerText = genre ?? 'Any genre';
        genreDropdownContainer.appendChild(select);

        const option = document.createElement('div');
        option.value = '';
        option.innerText = 'Any genre';
        option.classList.add('genre-option');
        option.setAttribute('value', 'Any genre');
        option.setAttribute('hidden', '');
        option.style.setProperty('--delay', `${order++ * 100}ms`);
        option.style.top = `${100 * order}%`;

        genreDropdownContainer.appendChild(option);
        this.genreBoxes.push(option);

        for (const genre of genres) {
            const option = document.createElement('div');
            option.value = genre;
            option.innerText = genre;
            option.classList.add('genre-option');
            option.setAttribute('value', genre);
            option.setAttribute('hidden', '');
            option.style.setProperty('--delay', `${order++ * 100}ms`);
            option.style.top = `${100 * order}%`;
            genreDropdownContainer.appendChild(option);
            this.genreBoxes.push(option);
        }
        this.genreSelector = select;

        let timeout = null;

        const onEnter = _ => {
            if (timeout) {
                clearTimeout(timeout);
            }

            this.genreBoxes.forEach(box => {
                box.classList.add('active');
            })
        };

        const onLeave = _ => {
            timeout = setTimeout(() => {
                this.genreBoxes.forEach(box => {
                    box.classList.remove('active');
                });
                timeout = null;
            }, 150)
        }

        this.genreSelector.addEventListener('mouseenter', onEnter);
        this.genreSelector.addEventListener('mouseleave', onLeave);
        this.genreBoxes.forEach(box => {
            box.addEventListener('mouseenter', onEnter);
            box.addEventListener('mouseleave', onLeave);

            box.style.setProperty('--delay-reverse', `${--order * 100}ms`);
            box.removeAttribute('hidden');

            box.addEventListener('click', _ => {
                const params = new URLSearchParams(window.location.search);
                this._fetch(this.page, params.get('s') ?? '', params.get('o') ?? '', box.value);
                this.genreSelector.setAttribute('value', box.value);
                this.genreSelector.textContent = box.textContent;
            });
        });

    }

    change(result, page) {
        const data = result["data"];
        const hasNext = result["hasNext"];

        this.page = page;
        this.data = data.map(song => {
            song['publish_date'] = new Date(song['publish_date']);
            return song;
        });

        if (this.page === 1) {
            this.hasPrev = false;
            this.prevButtons.forEach(button => {
                button.setAttribute('hidden', '');
            });
        } else {
            this.hasPrev = true;
            this.prevButtons.forEach(button => {
                button.removeAttribute('hidden');
            });
        }

        if (!hasNext) {
            this.hasNext = false;
            this.nextButtons.forEach(button => {
                button.setAttribute('hidden', '');
            });
        } else {
            this.hasNext = true;
            this.nextButtons.forEach(button => {
                button.removeAttribute('hidden');
            });
        }

        this.render();
    }

    next() {
        if (!this.hasNext) {
            return;
        }
        this._fetch(this.page + 1);
    }

    prev() {
        if (!this.hasPrev) {
            return;
        }
        this._fetch(this.page - 1);
    }

    render() {
        let order = 1;
        this.table.innerHTML = "";
        this.table.appendChild(this._renderHead());

        for (const entry of this.data) {
            this.table.appendChild(this._renderRow(entry, order));
            order++;
        }
    }

    _reset() {
        this.table.innerHTML = "";
        this.table.appendChild(this._renderHead());
        const loadingRow = document.createElement('td');
        loadingRow.innerText = 'Loading...';
        loadingRow.rowSpan = 7;
    }

    _fetch(page, sortBy = '', order = '', genre = '') {
        const endpoint = new URL('/search', window.location.origin);
        const queryParams = new URLSearchParams(window.location.search);
        queryParams.set('p', page);
        queryParams.set('d', '1');
        if (sortBy) {
            queryParams.set('s', sortBy);
            queryParams.set('o', order === 'ASCENDING' ? 'asc' : 'desc');
        }
        if (genre) {
            queryParams.set('g', genre);
        } else {
            queryParams.delete('g');
        }
        endpoint.search = queryParams.toString();

        this._reset();

        const xhr = new XMLHttpRequest();
        xhr.open('GET', endpoint);
        xhr.onload = _ => {
            const data = JSON.parse(xhr.responseText);
            this.change(data, page);

            const newUrl = new URL(window.location.origin);
            newUrl.pathname = window.location.pathname;
            if (queryParams.has('d')) {
                queryParams.delete('d');
            }
            newUrl.search = queryParams.toString();
            history.pushState(null, '', newUrl);
        }



        xhr.send();
    }

    _renderHead() {
        return this.head;
    }

    _renderRow(row, order) {
        const ord = order + (this.page - 1) * 20;
        const tableRow = document.createElement('tr');
        tableRow.innerHTML = `
            <td>${ord}</td>
                <td>${row['title']}</td>
                <td>${row['artist']}</td>
                <td>${row['genre']}</td>
                <td>${row['album_title']}</td>
                <td>${row['publish_date'].getFullYear()}</td>
                <td>${toDurationString(row['duration'])}</td>
        `;
        tableRow.addEventListener('click', () => {
            location.href = `/listen?s=${row['id']}`;
        })
        return tableRow;
    }

    _sortByTitle() {
        this._resetSort();

        if (!this.titleOrder) {
            this.titleOrder = 'ASCENDING';
        } else {
            this.titleOrder = this.titleOrder === 'ASCENDING'
                ? 'DESCENDING'
                : 'ASCENDING';
        }

        this.titleCell.classList.add(this.titleOrder.toLowerCase());

        this._fetch(this.page, 'title',  this.titleOrder, this.genreSelector.value);
    }

    _sortByYear() {
        this._resetSort();

        if (!this.yearOrder) {
            this.yearOrder = 'ASCENDING';
        } else {
            this.yearOrder = this.yearOrder === 'ASCENDING'
                ? 'DESCENDING'
                : 'ASCENDING';
        }

        this.yearCell.classList.add(this.yearOrder.toLowerCase());

        this._fetch(this.page, 'year',  this.yearOrder, this.genreSelector.value);
    }

    _resetSort() {
        this._removeSortClass(this.titleCell);
        this._removeSortClass(this.yearCell);
    }

    _removeSortClass(node) {
        node.classList.remove('ascending');
        node.classList.remove('descending');
    }
}
