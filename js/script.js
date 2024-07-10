function changeView(){
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function signUp(){
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var mobile = document.getElementById("mobile")
    var password = document.getElementById("password");
    var gender = document.getElementById("gender");

    var form = new FormData();

    form.append("f" , fname.value);
    form.append("l" , lname.value);
    form.append("e" , email.value);
    form.append("m" , mobile.value);
    form.append("p" , password.value);
    form.append("g" , gender.value);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(req.readyState == 4 && req.status == 200){
            var resp = req.responseText;
            if(resp == "success"){
                document.getElementById("msg").innerHTML = "Registration Successfull !";
                document.getElementById("msg").className = "alert alert-success";
                document.getElementById("magdiv").className = "d-block" ;
                changeView();
            }else{
                document.getElementById("msg").innerHTML = resp;
                document.getElementById("msgdiv").className = "d-block";
            }
        }
    }

    req.open("POST" , "signUpProcess.php" , true);
    req.send(form);
}