class TableRenderer {

    constructor(selector) {
        this.parent = document.querySelector(selector);
        this.data = {};

        this.hasNext = false;
        this.hasPrev = false;

        this.nextButtons = [];
        this.prevButtons = [];

        this.titleOrder = 'DESCENDING';
        this.titleCell = null;
        this.yearOrder = null;
        this.yearCell = null;

        this._createHead();
        this._createContent();

        this.titleCell.classList.add(this.titleOrder.toLowerCase());
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
        this.controlsUpper = this._createControls();
        this.controlsLower = this._createControls();
        this.table = document.createElement('table');

        this.parent.appendChild(this.controlsUpper);
        this.parent.appendChild(this.table);
        this.parent.appendChild(this.controlsLower);
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
        button.addEventListener('click', this.next);
        return button;

    }

    _createPrevButton() {
        const button = this._createButton('navigate_before');
        this.prevButtons.push(button);
        button.addEventListener('click', this.prev);
        return button;
    }

    _createButton(text) {
        const button = document.createElement('button');
        button.textContent = text;
        button.classList.add('material-symbols-rounded');
        button.classList.add('table-button');
        return button;
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
                button.setAttribute('hidden', true);
            });
        } else {
            this.hasPrev = true;
            this.prevButtons.forEach(button => {
                button.setAttribute('hidden', false);
            });
        }

        if (!hasNext) {
            this.hasNext = false;
            this.nextButtons.forEach(button => {
                button.setAttribute('hidden', true);
            });
        } else {
            this.hasNext = true;
            this.nextButtons.forEach(button => {
                button.setAttribute('hidden', false);
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

    _fetch(page) {
        const endpoint = new URL('/search.php');
        const queryParams = new Proxy(new URLSearchParams(window.location.search), {
            get: (queryParams, prop) => queryParams.get(prop),
        });
        queryParams.set('p', page);
        queryParams.set('d', '1');
        endpoint.search = queryParams.toString();

        const xhr = new XMLHttpRequest();
        xhr.open('GET', endpoint);
        xhr.onload = _ => {
            const data = JSON.parse(xhr.responseText);
            this.change(data, page);

        //    TODO: push state
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
            location.href = `/listen.php?s=${row['id']}`;
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

    //    TODO: fetch
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

        //    TODO: fetch

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
