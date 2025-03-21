  // Mostrar/Esconder o submenu ao clicar no título
  const submenuTitles = document.querySelectorAll('.submenu-title');
  submenuTitles.forEach(title => {
      title.addEventListener('click', () => {
          const submenuItems = title.nextElementSibling;
          submenuItems.classList.toggle('show');
      });
  });


  //Script para o Menu Dropdown 
  
   // Mostrar/Esconder o menu dropdown ao clicar no nome do usuário
   const userInfo = document.querySelector('.user-info');
   const dropdownMenu = document.querySelector('.dropdown-menu');

   userInfo.addEventListener('click', () => {
       dropdownMenu.classList.toggle('show');
   });

   // Fechar o menu quando clicar fora dele
   document.addEventListener('click', (event) => {
       if (!userInfo.contains(event.target)) {
           dropdownMenu.classList.remove('show');
       }
   });
