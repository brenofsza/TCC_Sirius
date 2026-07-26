document.querySelectorAll('.sidebar-navigation ul li').forEach(li => {
  li.addEventListener('click', function() {
    // Remove a classe active de quem tiver ela
    document.querySelector('.sidebar-navigation ul li.active')?.classList.remove('active');
    // Adiciona no item clicado
    this.classList.add('active');
  });
});
