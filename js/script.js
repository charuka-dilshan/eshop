function changeView() {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function signUp() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var mobile = document.getElementById("mobile")
    var password = document.getElementById("password");
    var gender = document.getElementById("gender");

    var form = new FormData();

    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("m", mobile.value);
    form.append("p", password.value);
    form.append("g", gender.value);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                document.getElementById("msg").innerHTML = "Registration Successfull !";
                document.getElementById("msg").className = "alert alert-success";
                document.getElementById("msgdiv").className = "d-block";
                changeView();
            } else {
                document.getElementById("msg").innerHTML = resp;
                document.getElementById("msgdiv").className = "d-block";
            }
        }
    }

    req.open("POST", "signUpProcess.php", true);
    req.send(form);
}

function signIn() {

    var email = document.getElementById("email2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("rememberMe");

    var form = new FormData();

    form.append("e", email.value);
    form.append("p", password.value);
    form.append("r", rememberMe.checked);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                window.location = "home.php"
            } else {
                document.getElementById("msg1").innerHTML = resp;
                document.getElementById("msgdiv1").className = "d-block";
            }
        }
    }

    req.open("POST", "signInProcess.php", true);
    req.send(form);

}

var forgotPasswordModal;

function forgotPassword() {


    var email = document.getElementById("email2");
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.status == 200 && req.readyState == 4) {
            var resp = req.responseText;
            if (resp == "success") {
                alert("Verification Code Has Sent Successfully To Your Email.");
                var modal = document.getElementById("fpmodal");
                forgotPasswordModal = new bootstrap.Modal(modal);
                forgotPasswordModal.show();
            } else {
            
                document.getElementById("msg1").innerHTML = resp;
                document.getElementById("msgdiv1").className = "d-block";

            }
        }
    }

    req.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    req.send();
}

function showPassword1() {
    var textField = document.getElementById("np");
    var button = document.getElementById("npb");

    if (textField.type == "password") {
        textField.type = "text";
        button.innerHTML = "Hide";
    } else {
        textField.type = "password";
        button.innerHTML = "Show";
    }
}

function showPassword2() {
    var textField = document.getElementById("rp");
    var button = document.getElementById("rpb");

    if (textField.type == "password") {
        textField.type = "text";
        button.innerHTML = "Hide";
    } else {
        textField.type = "password";
        button.innerHTML = "Show";
    }
}

function resetPassword(){

    var email = document.getElementById("email2");
    var newPassword = document.getElementById("np");
    var reTypedPassword = document.getElementById("rp");
    var verificationCode = document.getElementById("vcode");

    var form = new FormData();

    form.append("e" , email.value);
    form.append("np" , newPassword.value);
    form.append("rp" , reTypedPassword.value);
    form.append("v" , verificationCode.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
        if(req.readyState == 4 && req.status == 200){
            var resp = req.responseText;

            if(resp == "success"){
                alert("Password updated successfully");
                forgotPasswordModal.hide();
            }else{
                alert(resp);
            }

        }
    }

    req.open("POST" , "resetPasswordProcess.php" , true);
    req.send(form);

}

function signOut(){

    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if( resp == "success"){
                window.location.reload();
            }
        }
    }

    req.open("POST" , "signOutProcess.php" , true);
    req.send();

}

function showPassword3(){

    var pw = document.getElementById("pw");
    var pwi = document.getElementById("pwi");

    if(pw.type == "password"){
        pw.type = "text";
        pwi.className = "bi bi-eye-fill text-white";
    }else{
        pw.type = "password";
        pwi.className = "bi bi-eye-slash-fill text-white";
    }

}

function selectDistrict(){

    var province_id = document.getElementById("province").value;

    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
        if(req.readyState == 4 && req.status == 200){
            var resp = req.responseText;
            document.getElementById("district").innerHTML = resp;
        }
    }

    req.open("GET" , "selectDistrictProcess.php?id="+province_id , true);
    req.send();

}