document.addEventListener("DOMContentLoaded", () => {
  /**
   * @type {HTMLButtonElement}
   */
  let subscribeButtons = document.getElementsByClassName("subscribeButton");

  function subscribe(artistId, button) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/request");
    xhr.onload = () => {
      // alert(`Requested to subscribe to ${artistId}`);
      const parentNode = button.parentNode;
      const td = button.parentElement;
      parentNode.removeChild(button);
      td.innerText = "Requested";
    };
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(
      JSON.stringify({
        artist: artistId,
      })
    );
  }

  for (var i = 0; i < subscribeButtons.length; i++) {
    const button = subscribeButtons[i];
    const artistId = button.getAttribute("artistID");
    button.addEventListener("click", subscribe.bind(null, artistId, button));
  }
});
