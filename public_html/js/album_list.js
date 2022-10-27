function album_ClickHandler(id) {
    let loc = "/album_detail?s=";
    let loc_real = loc.concat(id);
    location.href = loc_real;
}

function album_detail_ClickHandler(id) {
    let loc = "/listen?s=";
    let loc_real = loc.concat(id);
    location.href = loc_real;
}


let editSongButton = document.getElementById("deleteAlbumSongButton");
editSongButton.addEventListener('click', function (event) {
    let text = "Are Your Sure to Delete Selected Song\nEither OK or Cancel.";
    var confirm_delete = confirm(text);
    let values = [];
    let checkboxes = document.querySelectorAll('input[name="color"]:checked');
    checkboxes.forEach((checkbox) => {
        values.push(checkbox.value);
    });

    const xhr = new XMLHttpRequest();
    xhr.open('POST', location.href);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = _ => {
        location.reload();
    };
    xhr.send(new URLSearchParams({ confirm_delete, values }).toString());
});
