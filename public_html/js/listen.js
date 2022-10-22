document.addEventListener('DOMContentLoaded', () => {
    const playBar = document.querySelector('.play-bar');
    const playback = document.querySelector('.audio-playback');
    const playButton = document.querySelector('.play-button');
    const player = new Player(playBar, playback);

    playButton.addEventListener('click', _ => {
        player.play();
        playBar.classList.add('active');
    });
});