class TableRenderer {

    constructor(selector) {
        this.parent = document.querySelector(selector);
        this.data = {};

        this.hasNext = false;
        this.hasPrev = false;
    }

    change(data, page) {
        this.page = page;
        this.data = data.map(song => {
            song['publish_date'] = new Date(song['publish_date']);
            return song;
        });

        if (this.page === 1) {
            this.hasPrev = false;
            // TODO: disable prev button

        } else {
            this.hasPrev = true;

            // TODO: enable prev button
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
        this.parent.innerHTML = `<table>${head}${rows}</table>`;
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
            <tr>
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
        const ord = order + this.page * 20;
        console.log(row)

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
