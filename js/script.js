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
  var mobile = document.getElementById("mobile");
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
  };

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
        window.location = "home.php";
      } else {
        document.getElementById("msg1").innerHTML = resp;
        document.getElementById("msgdiv1").className = "d-block";
      }
    }
  };

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
  };

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

function resetPassword() {
  var email = document.getElementById("email2");
  var newPassword = document.getElementById("np");
  var reTypedPassword = document.getElementById("rp");
  var verificationCode = document.getElementById("vcode");

  var form = new FormData();

  form.append("e", email.value);
  form.append("np", newPassword.value);
  form.append("rp", reTypedPassword.value);
  form.append("v", verificationCode.value);

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var resp = req.responseText;

      if (resp == "success") {
        alert("Password updated successfully");
        forgotPasswordModal.hide();
      } else {
        alert(resp);
      }
    }
  };

  req.open("POST", "resetPasswordProcess.php", true);
  req.send(form);
}

function signOut() {
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var resp = req.responseText;
      if (resp == "success") {
        window.location.reload();
      }
    }
  };

  req.open("POST", "signOutProcess.php", true);
  req.send();
}

function showPassword3() {
  var pw = document.getElementById("pw");
  var pwi = document.getElementById("pwi");

  if (pw.type == "password") {
    pw.type = "text";
    pwi.className = "bi bi-eye-fill text-white";
  } else {
    pw.type = "password";
    pwi.className = "bi bi-eye-slash-fill text-white";
  }
}

function selectDistrict() {
  var province_id = document.getElementById("province").value;

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var resp = req.responseText;
      document.getElementById("district").innerHTML = resp;
      selectCity();
    }
  };

  req.open("GET", "selectDistrictProcess.php?id=" + province_id, true);
  req.send();
}

function selectCity() {}

function changeProfileImg() {
  var img = document.getElementById("profileimage");

  img.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("img").src = url;
  };
}

function updateProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var city = document.getElementById("city");
  var pcode = document.getElementById("pcode");
  var image = document.getElementById("profileimage");

  var form = new FormData();

  form.append("f", fname.value);
  form.append("l", lname.value);
  form.append("m", mobile.value);
  form.append("li1", line1.value);
  form.append("li2", line2.value);
  form.append("c", city.value);
  form.append("i", image.files[0]);
  form.append("p", pcode.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var resp = req.responseText;
      if (resp == "updated" || resp == "saved") {
        window.location.reload();
      } else if (resp == "Please select a file.") {
        alert("You have not selected any profile image");
        window.location.reload();
      } else {
        alert(resp);
      }
    }
  };

  req.open("POST", "updateProfielProcess.php", true);
  req.send(form);
}

function addColor() {
  var clr = document.getElementById("new_clr");

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var resp = this.responseText;
      if (resp == "success") {
        Swal.fire({
          title: "Success!",
          text: "Color has registered successfully!",
          icon: "success",
        });
      } else {
        Swal.fire({
          title: "Error",
          text: resp,
          icon: "error",
        });
      }
    }
  };
  r.open("GET", "saveColorProcess.php?clr=" + clr.value, true);
  r.send();
}

function changeProductImage() {
  var image = document.getElementById("imageUploader");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count <= 3) {
      for (var x = 0; x < file_count; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);

        document.getElementById("i" + x).src = url;
      }
    } else {
      alert(
        file_count +
          " files selected. You can upload only 3 or less than 3 files."
      );
    }
  };
}

function addProduct(){
  var category = document.getElementById("category");
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var title = document.getElementById("title");
  var condition = 0;
  if (document.getElementById("b").checked){
    condition = 1;
  }else if (document.getElementById("u").checked){
    condition = 2;
  }
  var clr = document.getElementById("clr");
  var qty = document.getElementById("qty");
  var cost = document.getElementById("cost");
  var dwc = document.getElementById("in_colombo");
  var doc = document.getElementById("out_colombo");
  var desc = document.getElementById("desc");
  var imageUploader = document.getElementById("imageUploader");

  var form = new FormData;

  form.append("ca" , category.value);
  form.append("b" , brand.value);
  form.append("m" , model.value);
  form.append("t" , title.value);
  form.append("co" , condition);
  form.append("clr" , clr.value);
  form.append("qty" , qty.value);
  form.append("cost" , cost.value);
  form.append("dwc" , dwc.value);
  form.append("doc" , doc.value);
  form.append("d" , desc.value);

  var file_count = imageUploader.files.length;

  for(var x = 0 ; x<3 ; x++){
    form.append("image"+ x , imageUploader.files[x]);
  }

  var req = new XMLHttpRequest();

  req.onreadystatechange = function(){
    if(req.readyState == 4 && req.status == 200 ){
      resp = req.responseText;

      if(resp == "success"){
        alert("product saved successfully");
        window.location.reload();
      }else{
        alert(resp);
      }

    }
  }

  req.open("POST" , "addProductProcess.php" , true);
  req.send(form);

}

function changeStatus(id){
  var req = new XMLHttpRequest();

  req.onreadystatechange = function(){
    if(req.readyState == 4 && req.status == 200){
      var resp = this.responseText;
      if(resp == "Activated" || resp == "Deactivated"){
        window.location.reload();
      }else{
        alert(resp);
      }
    }
  }

  req.open("GET" , "changeStatusProcess.php?id="+id , true);
  req.send();
}

function sort1(x){
  var search = document.getElementById("s");
  var time = "0";

  if(document.getElementById("n").checked){
    time = "1";  
  }else if(document.getElementById("o").checked){
    time = "2";
  }


  var qty = "0";

  if(document.getElementById("h").checked){
    qty = "1";  
  }else if(document.getElementById("l").checked){
    qty = "2";
  }


  var condition = "0";

  if(document.getElementById("b").checked){
    condition = "1";  
  }else if(document.getElementById("u").checked){
    condition = "2";
  }

  var form = new FormData;
  form.append("t" , time);
  form.append("q" , qty);
  form.append("s" , search.value);
  form.append("c" , condition);
  form.append("page" , x);

  var req= new XMLHttpRequest();

  req.onreadystatechange = function () {
    if(req.readyState == 4 && req.status == 200){
      var resp = req.responseText;
      document.getElementById("sort").innerHTML = resp;
    }
  }

  req.open("POST" , "sortProcess.php" , true);
  req.send(form);

}

function clearSort(){
  window.location.reload();
}

function updateProduct(id){

  var title = document.getElementById("t");
  var qty = document.getElementById("q");
  var dwc = document.getElementById("dwc");
  var doc = document.getElementById("doc");
  var images = document.getElementById("imageUploader");
  var desc = document.getElementById("d");

  var form = new FormData();
  form.append("t" , title.value);
  form.append("q" , qty.value);
  form.append("dwc" , dwc.value);
  form.append("doc" , doc.value);
  form.append("d" , desc.value);
  form.append("id" , id);

  var count = images.files.length;

  for(var x = 0; x<count ; x++){
    form.append("i"+x , images.files[x]);
  }

  var req = new XMLHttpRequest();
  req.onreadystatechange = function(){
    if(req.readyState == 4 && req.status == 200){
      var resp = req.responseText;
    }
  }

  req.open("POST" , "updateProductProcess.php" , true)
  req.send(form)
}

function advancedSearch(x){

  var text = document.getElementById("t");
  var category = document.getElementById("c1");
  var brand = document.getElementById("b1");
  var model = document.getElementById("m");
  var condition = document.getElementById("c2");
  var color = document.getElementById("c3");
  var from = document.getElementById("pf");
  var to = document.getElementById("pt");
  var sort = document.getElementById("s");

  var form = new FormData();
  
  form.append("t" , text.value);
  form.append("cat" , category.value);
  form.append("b" , brand.value);
  form.append("m" , model.value);
  form.append("con" , condition.value);
  form.append("col" , color.value);
  form.append("pf" , from.value);
  form.append("pt" , to.value);
  form.append("s" , sort.value);
  form.append("page" , x);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function(){
    if(req.readyState == 4 && req.status == 200){
      var resp = req.responseText;
      document.getElementById("view_area").innerHTML = resp;
    }
  }

  req.open("POST" , "advancedSearchProcess.php" , true);
  req.send(form);

}