class TableRenderer {

    constructor(selector) {
        this.parent = document.querySelector(selector);
        this.data = {};
    }

    change(data, page) {
        this.page = page;
        this.data = data.map(song => {
            song['publish_date'] = new Date(song['publish_date']);
            return song;
        });

        this.render();
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
