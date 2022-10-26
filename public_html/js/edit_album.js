let editButton = document.getElementById("editButton");
editButton.addEventListener('click', function (event) {
    let hero = document.getElementById("Album_Bar");

    let formElmt = document.createElement("form");
    formElmt.setAttribute("action", "album_detail.php");
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

    br1 = document.createElement("br");
    br2 = document.createElement("br");

    inputImage = document.createElement("input");
    inputImage.setAttribute("type", "file");
    inputImage.setAttribute("id", "inputImage");
    inputImage.setAttribute("class", "editTextInput");
    labelImage = document.createElement("label");
    labelImage.setAttribute("for", "inputImage");
    labelImage.innerHTML = "Upload image: ";

    uploadContainer = document.getElementById("fileUploadContainer");
    uploadContainer.appendChild(labelImage);
    uploadContainer.appendChild(inputImage);

    editButton = document.getElementById("editButton");
    editButton.innerHTML = "";

    submitButton = document.createElement("button");
    submitButton.setAttribute("type", "submit");
    submitButton.setAttribute("id", "submitSongChange");
    submitButton.setAttribute("name", "submitSongChange");
    submitButton.innerHTML = "Submit";

    uploadContainer.appendChild(br2);
    uploadContainer.appendChild(submitButton);

    hero.style.marginTop = "110px";


});


let deleteButton = document.getElementById("deleteButton");
deleteButton.addEventListener('click', function (event) {
    let text = "Are Your Sure to Delete this Album\nEither OK or Cancel.";
    if (confirm(text) == true) {
        text = "Album Deleted";
    } else {
        text = "You canceled!";
    }
});