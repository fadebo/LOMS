const passwordField = document.querySelector(".form form input[name='password']"),
toggleIcons = document.querySelector(".form form .container .fa-eye");
toggleIcons.onclick = () =>{
  if(passwordField.type === "password"){
    passwordField.type = "text";
    toggleIcons.classList.add("active");
  }else{
    passwordField.type = "password";
    toggleIcons.classList.remove("active");
  }
}
