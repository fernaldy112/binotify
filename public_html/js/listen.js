document.addEventListener('DOMContentLoaded', () => {
    const playBar = document.querySelector('.play-bar');
    const playback = document.querySelector('.audio-playback');
    const playButton = document.querySelector('.play-button');
    const player = new Player(playBar, playback);

    playButton.addEventListener('click', _ => {
        player.play();
        playBar.classList.add('active');
    });

    let deleteButton = document.getElementById("deleteButton");
    deleteButton.addEventListener('click', function (event) {
        let text = "Are Your Sure to Delete this Song\nEither OK or Cancel.";
        var result = confirm(text);
        var arr = {};
        arr.result = result;
        if (result) {
            text = "Song Deleted";
        } else {
            text = "Canceled";
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', location.href);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = _ => {
            location.href = '/';
        };
        xhr.send(new URLSearchParams({ result }).toString());
    });

});