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
