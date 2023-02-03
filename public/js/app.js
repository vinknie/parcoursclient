// toggle submenu sidebar
function displayPageSubmenu() {
  var pageSubmenu = document.getElementById("pageSubmenu");
  if (pageSubmenu.style.display === "block") {
    pageSubmenu.style.display = "none";
  } else {
    pageSubmenu.style.display = "block";
    pageSubmenu.classList.remove('collapse')
  }
}


document.querySelector("a.dropdown-toggle").addEventListener("click", function() {
  displayPageSubmenu();
});

console.log('hi')