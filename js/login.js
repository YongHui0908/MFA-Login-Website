const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#psw");

togglePassword.addEventListener("click", function () {
  // toggle the type attribute
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
                
  // toggle the icon
  this.classList.toggle("bi-eye");
});

// Preloader JavaScript
var loader = document.getElementById("preloader");
window.addEventListener("load", function() {
  loader.style.display = "none";
});
