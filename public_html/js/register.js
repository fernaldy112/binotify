const DELAY = 300;
let timeout = null;

function checkUnique(changed) {
    if (timeout) {
        clearTimeout(timeout);
    }

    timeout = setTimeout(() => {
        _checkUnique(changed);
    }, DELAY);

}

function _checkUnique(changed) {
    let email = document.getElementById("userEmailRegister").value;
    let username = document.getElementById("userNameRegister").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (xhttp.readyState == 4 && xhttp.status == 200){
            if (changed === "email"){
                let inputBox = document.getElementById("userEmailRegister");
                if (xhttp.responseText){
                    inputBox.style.borderColor = "green";
                    let errorMsg = document.getElementById("emailNotUniqueMsg");
                    let emailContainer = document.getElementById("registerEmailContainer");
                    emailContainer.removeChild(errorMsg);
                } else {
                    inputBox.style.borderColor = "red";
                    let errorMsg = document.createElement("p");
                    errorMsg.setAttribute("id", "emailNotUniqueMsg");
                    errorMsg.setAttribute("class", "notUniqueMsg");
                    errorMsg.innerHTML = "Email has already been used.";
                    let emailContainer = document.getElementById("registerEmailContainer");
                    emailContainer.appendChild(errorMsg);
                }
            } else if (changed === "username"){
                let inputBox = document.getElementById("userNameRegister");
                if (xhttp.responseText){
                    inputBox.style.borderColor = "green";
                    let errorMsg = document.getElementById("usernameNotUniqueMsg");
                    let usernameContainer = document.getElementById("registerUsernameContainer");
                    usernameContainer.removeChild(errorMsg);
                } else {
                    inputBox.style.borderColor = "red";
                    let errorMsg = document.createElement("p");
                    errorMsg.setAttribute("id", "usernameNotUniqueMsg");
                    errorMsg.setAttribute("class", "notUniqueMsg");
                    errorMsg.innerHTML = "Username has already been used.";
                    let usernameContainer = document.getElementById("registerUsernameContainer");
                    usernameContainer.appendChild(errorMsg);
                }
            }
        }
    };
    xhttp.open("POST", "ajax.php", true); //changed
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var param = "changed="+changed+"&email="+email+"&username="+username;
    xhttp.send(param);
}
