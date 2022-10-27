function checkUnique(changed){
    var email = document.getElementById("userEmailRegister").value;
    var username = document.getElementById("userNameRegister").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (xhttp.readyState == 4 && xhttp.status == 200){
            if (changed === "email"){
                var inputBox = document.getElementById("userEmailRegister");
                if (xhttp.responseText){
                    inputBox.style.borderColor = "green";
                } else {
                    inputBox.style.borderColor = "red";
                }
            } else if (changed === "username"){
                var inputBox = document.getElementById("userNameRegister");
                if (xhttp.responseText){
                    inputBox.style.borderColor = "green";
                } else {
                    inputBox.style.borderColor = "red";
                }
            }
        }
    };
    xhttp.open("POST", "ajax.php", true); //changed
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var param = "changed="+changed+"&email="+email+"&username="+username;
    xhttp.send(param);
}

// TODO: debounce function