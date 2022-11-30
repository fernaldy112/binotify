document.addEventListener('DOMContentLoaded', () => {
    let subscribeButtons = document.getElementsByClassName("subscribeButton");
    // console.log(subscribeButtons);
    // console.log(subscribeButtons.length);

    

    function subscribe(artistId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost:8080/request');
        xhr.onload = () => {
            // Do something
            alert(`Requested to subscribe to ${artistId}`);
        }
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({
            artist: artistId
        }));
    }
    
    for (var i = 0; i < subscribeButtons.length; i++) {
        const button = subscribeButtons[i];
        const artistId = button.getAttribute("artistID");
        button.addEventListener('click', subscribe.bind(null, artistId));
    }

});
