const menu = document.querySelector('.menu');
const dropdown_menu = document.querySelector('.dropdown_menu');

  menu.onclick = function () {
  dropdown_menu.classList.toggle('open'); 
  };