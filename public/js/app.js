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

const submenu = document.querySelector("a.dropdown-toggle")
if(submenu) submenu.addEventListener("click", function() {
  displayPageSubmenu();
});



// chart js