// toggle submenu sidebar
function displayPageSubmenu() {
  var pageSubmenu = document.getElementById("pageSubmenu");
  if (pageSubmenu.classList.contains('block')) {
    pageSubmenu.classList.add('hidden');
  } else {
    pageSubmenu.classList.add('block');
    pageSubmenu.classList.remove('collapse');
  }
}


document.querySelector("a.dropdown-toggle").addEventListener("click", function() {
  displayPageSubmenu();
});