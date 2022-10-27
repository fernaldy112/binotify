let editButton = document.getElementById("editButton");
editButton.addEventListener('click', function(event){
    let hero = document.getElementById("hero");
    
    let formElmt = document.createElement("form");
    formElmt.setAttribute("action", "editsong.php");
    formElmt.setAttribute("method", "post");
    formElmt.setAttribute("id", "editSongForm");
    formElmt.setAttribute("enctype", "multipart/form-data");
    formElmt.innerHTML = hero.innerHTML;
    
    hero.innerHTML = "";
    hero.appendChild(formElmt);
    
    let title = document.getElementById("span-title");
    let date = document.getElementById("span-date");
    let genre = document.getElementById("span-genre");
    
    let inputTitle = document.createElement("input");
    inputTitle.setAttribute("type", "text");
    inputTitle.setAttribute("id", "inputTitle");
    inputTitle.setAttribute("class", "editTextInput");
    inputTitle.setAttribute("name", "inputTitle");
    inputTitle.setAttribute("placeholder", "Enter song title");
    inputTitle.setAttribute("value", title.innerHTML);

    title.innerHTML = "";
    title.appendChild(inputTitle); 

    let inputDate = document.createElement("input");
    inputDate.setAttribute("type", "date");
    inputDate.setAttribute("id", "inputDate");
    inputDate.setAttribute("class", "editTextInput");
    inputDate.setAttribute("name", "inputDate");
    inputDate.setAttribute("value", date.innerHTML);

    date.innerHTML = "";
    date.appendChild(inputDate);

    let inputGenre = document.createElement("input");
    inputGenre.setAttribute("type", "text");
    inputGenre.setAttribute("id", "inputGenre");
    inputGenre.setAttribute("class", "editTextInput");
    inputGenre.setAttribute("name", "inputGenre");
    inputTitle.setAttribute("placeholder", "Enter song genre");
    inputGenre.setAttribute("value", genre.innerHTML);

    genre.innerHTML = "";
    genre.appendChild(inputGenre);

    let inputFile = document.createElement("input");
    inputFile.setAttribute("type", "file");
    inputFile.setAttribute("id", "inputFile");
    inputFile.setAttribute("name", "inputFile");
    inputFile.setAttribute("class", "editTextInput");
    labelFile = document.createElement("label");
    labelFile.setAttribute("for", "inputFile");
    labelFile.innerHTML = "Upload song: ";

    let br1 = document.createElement("br");
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
    uploadContainer.appendChild(labelFile);
    uploadContainer.appendChild(inputFile);
    uploadContainer.appendChild(br1);
    uploadContainer.appendChild(labelImage);
    uploadContainer.appendChild(inputImage);

    let editButton = document.getElementById("editButton");
    editButton.innerHTML = "";

    let submitButton = document.createElement("button");
    submitButton.setAttribute("type", "submit");
    submitButton.setAttribute("id", "submitSongChange");
    submitButton.setAttribute("name", "submitSongChange");
    submitButton.innerHTML = "Submit";

    uploadContainer.appendChild(br2);
    uploadContainer.appendChild(submitButton);

    hero.style.marginTop = "110px";

});