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
        this.time = 0;
        this.ended = false;

        this.updateTimeout = null;
        this.durationTimeout = null;

        this.initListeners();

        setInterval(this._sync.bind(this), 10000)
    }

    initListeners() {
        this.volumeButton.addEventListener('click', e => {
            if (this.volumeOn) {
                this._mute();
            } else {
                this._unmute();
            }
        });

        this.volumeSlider.addEventListener('input', _ => {
            if (this.updateTimeout) {
                return;
            }

            this._updateVolume();
        });

        this.volumeSlider.addEventListener('change', e => {
            this._forceUpdateVolume();
        })

        this.playButton.addEventListener('click', _ => {
            if (this.paused || this.ended) {
                this.play();
            } else {
                this.pause();
            }
        });

        this.parent.addEventListener('timeupdate', _ => {
                this._updateTime();
            }
        );

        this.parent.addEventListener('ended', _ => {
            this._stopDurationTimeout();
            this.ended = true;
            this._stop();
        });

        this.progressBar.addEventListener('click', e => {
            /**
             * @type {PointerEvent}
             */
            let event = e;
            const offset = this.progressBar.getBoundingClientRect().left;
            const diff = event.clientX - offset;
            const progress = diff / this.progressBar.clientWidth;
            this.seek(progress * this.parent.duration);
        })
    }

    play() {
        if (this.ended) {
            this.ended = false;
            this.time = 0;
            this._updateProgress();
        }

        this.parent.play().then(() => {
            this._startDurationTimeout();
            this.paused = false;
            this.playButton.children[0].textContent = 'pause_circle';
        });
    }

    pause() {
        this.parent.pause();
        this.paused = true;
        this._stop()
    }

    _stop() {
        this.playButton.children[0].textContent = 'play_circle';
        this._stopDurationTimeout();
    }

    seek(time) {
        this.time = Math.round(time);
        this.parent.currentTime = time;
        this._updateTime();
    }

    _updateVolume() {
        this.updateTimeout = setTimeout(() => {
            clearTimeout(this.updateTimeout)
            this.updateTimeout = null;
        }, 100);

        const newVolume = parseInt(this.volumeSlider.value);

        if (newVolume === 0) {
            this._mute();
            return;
        }

        if (!this.volumeOn) {
            this._unmute();
        }

        this.volume = newVolume;
        this.parent.volume = this.volume / 100;
    }

    _mute() {
        this.parent.muted = true;
        this.volumeOn = false;
        this.volumeButton.children[0].textContent = 'volume_off';
    }

    _unmute() {
        this.parent.muted = false;
        this.volumeOn = true;
        this.volumeButton.children[0].textContent = 'volume_up';
    }

    _forceUpdateVolume() {
        clearTimeout(this.updateTimeout);
        this._updateVolume();
    }

    _startDurationTimeout() {
        this.durationTimeout = setTimeout(() => {
            this.time += 1;
            this._updateTime();
            this._startDurationTimeout();
        }, 1000);
    }

    _stopDurationTimeout() {
        clearTimeout(this.durationTimeout);
    }

    _updateTime() {
        this.playbackTime.textContent = this._formatTime();
        this._updateProgress();
    }

    _updateProgress() {
        const progress = this.time / this.parent.duration * 100;
        this.progressBar.children[0].style.left = `${progress - 100}%`;
    }

    _sync() {
        this.time = Math.round(this.parent.currentTime);
        console.log(this.time)
    }

    _formatTime() {
        return toDurationString(this.time);
    }
}

