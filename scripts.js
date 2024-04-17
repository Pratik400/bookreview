document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".coming-soon");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      event.preventDefault();
      alert("Webpage Coming soon!");
    });
  });
});



//// NAVBAR TOGGLE
document.addEventListener("DOMContentLoaded", function () {
  var navbarToggle = document.getElementById("navbar-toggle");
  var navbarList = document.getElementById("nav-list");

  navbarToggle.addEventListener("click", function () {
    this.classList.toggle("active");
    navbarList.classList.toggle("active");
  });

  window.addEventListener("resize", function () {
    var screenWidth = window.innerWidth;
    if (screenWidth > 800) {
      navbarToggle.classList.remove("active");
      navbarList.classList.remove("active");
    }
  });
});




////// CSS CHANGE FUNCTIONALITY

// Default CSS file
var defaultCSS = "assets/css/style1.css";
// Function to toggle between CSS files
function toggleCSS() {
  var currentCSS = localStorage.getItem("currentCSS");
  var newCSS;

  // Check which CSS file is in use and toggle
  if (currentCSS === "assets/css/style1.css") {
    newCSS = "assets/css/style2.css";
  } else {
    newCSS = "assets/css/style1.css";
  }

  // Set the new CSS file in the localStorage
  localStorage.setItem("currentCSS", newCSS);
  document.getElementById("css-link").setAttribute("href", newCSS);
}

// On page load, check if there is CSS file in localStorage
document.addEventListener("DOMContentLoaded", function () {
  var currentCSS = localStorage.getItem("currentCSS") || defaultCSS;
  if (currentCSS) {
    document.getElementById("css-link").setAttribute("href", currentCSS);
  } else {
    localStorage.setItem("currentCSS", "assets/css/style1.css");
    document
      .getElementById("css-link")
      .setAttribute("href", "assets/css/style1.css");
  }
});
