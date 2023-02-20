

// toggle submenu sidebar
// function displayPageSubmenu() {
//   const pageSubmenu = document.getElementById("pageSubmenu");
//   if (pageSubmenu.classList.contains('block')) {
//     pageSubmenu.classList.toggle('hidden');
//     localStorage.setItem('submenu', 'hidden');
//   } else {
//     pageSubmenu.classList.add('block');
//     pageSubmenu.classList.remove('collapse');
//     localStorage.setItem('submenu', 'block')
//   }
// }


const submenuBtn = document.querySelector("a.dropdown-toggle");
const pageSubmenu = document.getElementById("pageSubmenu");


if(submenuBtn) submenuBtn.addEventListener("click", function() {
  pageSubmenu.classList.toggle('collapse');
});
