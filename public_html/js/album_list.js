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
    document.cookie = "confirm_delete=" + confirm_delete + ";max-age=1";
    document.cookie = "values=" + values + ";max-age=3";
    console.log(document.cookie);
    location.reload();
});