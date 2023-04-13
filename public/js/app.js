

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


//  S W E E T A L E R T   C O N F I R M   M O D A L
// category delete (/dashboard/category)
const categoryDeleteBtns = document.querySelectorAll('.cat_delete_btns');

if(categoryDeleteBtns) {
   categoryDeleteBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
         e.preventDefault();
         const href = e.target.closest('a').href;

         Swal.fire({
            title: 'Êtes vous sur de vouloir supprimé?',
            text: "Les verbatims seront placés sous la catégorie 'Verbatims sans étape'",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: `Annuler`,
            cancelButtonColor: '#EE8989',
            icon: 'warning'
            }).then((result) => {
               if(result.isConfirmed) {
                  window.location.href = href;
               } else {
                  return false;
               }
         });
      });
   })
}

// verbatim delete (/dashboard/category/editcategory/:id)
const verbatimDeleteBtns = document.querySelectorAll('.verbatim_delete_btns');
if(verbatimDeleteBtns) {
   Array.from(verbatimDeleteBtns).forEach(btn => {
      btn.addEventListener('click', (e) => {
         const {parentNode} = btn;
         const id = parentNode.querySelector('input[type="hidden"]').getAttribute('data-id');
         
         Swal.fire({
            title: 'Etes vous sur de vouloir supprimé?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: `Annuler`,
            cancelButtonColor: '#EE8989',
            icon: 'warning'
            }).then((result) => {
            if(result.isConfirmed) {
                // AJAX request to delete the verbatim with the given ID
                fetch('/dashboard/category/deleteVerba/' + id, {
                   method: 'DELETE',
                   headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                      'Content-Type': 'application/json'
                   },
                   body: JSON.stringify({id})
                }).then(response => {
                   if (response.ok) {
                      window.location.reload();
                   } else {
                      Swal.fire('Une erreur s\'est produite lors de la suppression de l\'élément.', '', 'error');
                   }
                }).catch(error => {
                   Swal.fire('Une erreur s\'est produite lors de la suppression de l\'élément : ', '', 'error');
                });
            } else {
                Swal.fire('Action annulée', '', 'success');
            }
          });
      })
   });
};