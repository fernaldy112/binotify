class Player {

    /**
     *
     * @param {HTMLElement} playBar Play bar for this player to attach to.
     * @param {HTMLAudioElement} parent Audio element for this player to attach to.
     */
    constructor(playBar, parent) {
        this.progressBar = playBar.children[1].children[1].children[1];
        this.playbackTime = playBar.children[1].children[1].children[0];
        /**
         * @type {HTMLButtonElement}
         */
        this.playButton = playBar.children[1].children[0];
        /**
         * @type {HTMLButtonElement}
         */
        this.volumeButton = playBar.children[2].children[0];
        /**
         * @type {HTMLInputElement}
         */
        this.volumeSlider = playBar.children[2].children[1];

        this.parent = parent;

        this.volumeOn = true;
        this.volume = 100;
        this.paused = false;

        this.updateTimeout = null;

        this.initListeners();
    }

    initListeners() {
        this.volumeButton.addEventListener('click', e => {
            if (this.volumeOn) {
                this.parent.muted = true;
                this.volumeButton.children[0].textContent = 'volume_off';
            } else {
                this.parent.muted = false;
                this.volumeButton.children[0].textContent = 'volume_up';
            }

            this.volumeOn = !this.volumeOn;
        });

        this.volumeSlider.addEventListener('input', e => {
            if (this.updateTimeout) {
                return;
            }

            this.updateTimeout = setTimeout(() => {
                this.updateTimeout = null;
            }, 100);

            const newVolume = parseInt(this.volumeSlider.value);

            if (newVolume === 0) {
                this.parent.muted = true;
                this.volumeOn = false;
                return;
            }

            this.volumeOn = true;
            this.volume = newVolume;
            this.parent.volume = this.volume / 100;
        });

        this.playButton.addEventListener('click', _ => {
            if (this.paused) {
                this.play();
            } else {
                this.pause();
            }
        });

    }

    play() {
        this.parent.play().then(() => {
            this.paused = false;
            this.playButton.children[0].textContent = 'play_circle';
        });
    }

    pause() {
        this.parent.pause();
        this.paused = true;
        this.playButton.children[0].textContent = 'pause_circle';
    }
}

