let editButton = document.getElementById("editButton");
editButton.addEventListener('click', function (event) {
    let hero = document.getElementById("Album_Bar");

    let formElmt = document.createElement("form");
    formElmt.setAttribute("action", "editalbum.php");
    formElmt.setAttribute("method", "post");
    formElmt.setAttribute("id", "editAlbumForm");
    formElmt.setAttribute("enctype", "multipart/form-data");
    formElmt.innerHTML = hero.innerHTML;

    hero.innerHTML = "";
    hero.appendChild(formElmt);

    let title = document.getElementById("span-title");
    let artist = document.getElementById("span-artist");

    let inputTitle = document.createElement("input");
    inputTitle.setAttribute("type", "text");
    inputTitle.setAttribute("id", "inputTitle");
    inputTitle.setAttribute("class", "editTextInput");
    inputTitle.setAttribute("name", "inputTitle");
    inputTitle.setAttribute("placeholder", "Enter album title");
    inputTitle.setAttribute("value", title.innerHTML);

    title.innerHTML = "";
    title.appendChild(inputTitle);

    let inputArtist = document.createElement("input");
    inputArtist.setAttribute("type", "text");
    inputArtist.setAttribute("id", "inputArtist");
    inputArtist.setAttribute("class", "editTextInput");
    inputArtist.setAttribute("name", "inputArtist");
    inputArtist.setAttribute("placeholder", "Enter album artist");
    inputArtist.setAttribute("value", artist.innerHTML);

    artist.innerHTML = "";
    artist.appendChild(inputArtist);

    let br2 = document.createElement("br");

    let inputImage = document.createElement("input");
    inputImage.setAttribute("type", "file");
    inputImage.setAttribute("id", "inputImage");
    inputImage.setAttribute("name", "inputImage");
    inputImage.setAttribute("class", "editTextInput");
    let labelImage = document.createElement("label");
    labelImage.setAttribute("for", "inputImage");
    labelImage.innerHTML = "Upload image: ";

    let uploadContainer = document.getElementById("fileUploadContainer");
    uploadContainer.appendChild(labelImage);
    uploadContainer.appendChild(inputImage);

    let editButton = document.getElementById("editButton");
    editButton.innerHTML = "";

    let submitButton = document.createElement("button");
    submitButton.setAttribute("type", "submit");
    submitButton.setAttribute("id", "submitAlbumChange");
    submitButton.setAttribute("name", "submitAlbumChange");
    submitButton.innerHTML = "Submit";

    uploadContainer.appendChild(br2);
    uploadContainer.appendChild(submitButton);

    hero.style.marginTop = "110px";


});

let deleteButton = document.getElementById("deleteButton");

deleteButton.addEventListener('click', function (event) {
    let text = "Are Your Sure to Delete this Album\nEither OK or Cancel.";
    var result = confirm(text);
    var arr = {};
    arr.result = result;
    if (result) {
        text = "Album Deleted";
    } else {
        text = "You canceled!";
    }
    document.cookie = "result=" + result + ";max-age=1";
    console.log(document.cookie);
    location.reload();

});

function show_alert() {
    alert("Cannot Delete Album!\nAlbum not Empty")
}