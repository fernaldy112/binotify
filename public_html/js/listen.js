/**
 *
 * @param {number} duration
 */
function getDurationString(duration) {
  const hour = Math.floor(duration / 3600);
  const minutePortion = duration % 3600;
  let min = Math.floor(minutePortion / 60);
  let sec = minutePortion % 60;

  console.log(hour);
  console.log(min);
  console.log(sec);

  let durationString = "";
  if (hour > 0) {
    durationString = `${hour}:`;
    min = `${min}`.padStart(2, "0");
  }
  sec = `${sec}`.padStart(2, "0");
  return `${durationString}${min}:${sec}`;
}

document.addEventListener("DOMContentLoaded", () => {
  let playBar = document.querySelector(".play-bar");
  const playButtons = document.querySelectorAll(".play-button");
  /**
   * @type {HTMLSpanElement}
   */
  const duration = document.querySelector(".playback-duration");
  var player;

  playButtons.forEach((playButton, index) => {
    /**
     * @type { HTMLAudioElement }
     */
    const playback = document.querySelectorAll(".audio-playback")[index];

    playButton.addEventListener("click", (_) => {
      if (player) {
        player.destruct();
        const newPlayBar = playBar.cloneNode(true);
        playBar.parentNode.replaceChild(newPlayBar, playBar);
        playBar = newPlayBar;
      }

      player = new Player(playBar, playback);

      player.play();
      playBar.classList.add("active");
      if (duration) {
        duration.innerText = getDurationString(Math.round(playback.duration));
      }
    });
  });

  let deleteButton = document.getElementById("deleteButton");
  deleteButton.addEventListener("click", function (event) {
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
    xhr.open("POST", location.href);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = (_) => {
      if (result) {
        location.href = location.origin;
      }
    };
    xhr.send(new URLSearchParams({ result }).toString());
  });
});
