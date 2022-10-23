class TableRenderer {

    constructor(selector) {
        this.parent = document.querySelector(selector);
        this.data = {};

        this.hasNext = false;
        this.hasPrev = false;

        this.nextButtons = [];
        this.prevButtons = [];

        this._createContent();
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

    change(data, page) {
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

        // TODO: check has next

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
        const head = this._renderHead();
        let order = 1;
        let rows = '';

        for (const entry of this.data) {
            rows += this._renderRow(entry, order);
            order++;
        }
        this.table.innerHTML = `${head}${rows}`;
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
        return `
            <tr class="head">
                <th>#</th>
                <th>TITLE</th>
                <th>ARTIST</th>
                <th>GENRE</th>
                <th>ALBUM</th>
                <th>PUBLISHED YEAR</th>
                <th>LENGTH</th>
            </tr>
        `;
    }

    _renderRow(row, order) {
        const ord = order + (this.page - 1) * 20;

        return `
            <tr>
                <td>${ord}</td>
                <td>${row['title']}</td>
                <td>${row['artist']}</td>
                <td>${row['genre']}</td>
                <td>${row['album_title']}</td>
                <td>${row['publish_date'].getFullYear()}</td>
                <td>${toDurationString(row['duration'])}</td>
            </tr>
        `;
    }
}
