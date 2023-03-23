

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


const submenuBtn  = document.querySelector("a.dropdown-toggle");
const pageSubmenu = document.getElementById("pageSubmenu");
if(submenuBtn) submenuBtn.addEventListener("click", () => pageSubmenu.classList.toggle('collapse'));  



// liste d'utilisateur
const trashedBtn = document.querySelector('.trash-user-container h2.cursor-pointer');
const trashedTable = document.querySelector('#trashed-usertable');
const trashedEyeIcon = document.querySelector('.trash-user-container h2.cursor-pointer i');

if(trashedBtn) {
   trashedBtn.addEventListener('click', () => {
      trashedTable.classList.toggle('hidden');
      trashedEyeIcon.classList.toggle('fa-eye')
   })
}

// success msg cross btn
const success__crossBtn = document.querySelector('.success__cross-btn');
const successMsg = document.querySelector('.success-msg');
if(success__crossBtn) success__crossBtn.addEventListener('click', () => successMsg.style.display = 'none');