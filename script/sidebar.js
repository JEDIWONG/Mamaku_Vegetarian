const side_menu = document.querySelector('.side_menu'); 
const dropdown_sidebar = document.querySelector('.dropdown_sidebar'); 

  side_menu.onclick = function () {
  dropdown_sidebar.classList.toggle('open'); 
  };