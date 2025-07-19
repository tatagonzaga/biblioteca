import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Função de alternância de tema com debug visual
window.toggleTheme = function() {
    const html = document.documentElement;
    const isCurrentlyDark = html.classList.contains('dark');
    
    if (isCurrentlyDark) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        console.log('Mudou para light mode - Classe dark removida:', !html.classList.contains('dark'));
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        console.log('Mudou para dark mode - Classe dark adicionada:', html.classList.contains('dark'));
    }
    
    // Debug adicional - mostrar classes do html
    console.log('Classes atuais do HTML:', html.className);
    
    // Forçar reflow para garantir que as mudanças sejam aplicadas
    html.offsetHeight;
}

// Carregar tema salvo imediatamente
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

console.log('Tema salvo:', savedTheme);
console.log('Prefere dark do sistema:', prefersDark);

if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
    document.documentElement.classList.add('dark');
    console.log('Aplicou dark mode no carregamento');
} else {
    document.documentElement.classList.remove('dark');
    console.log('Aplicou light mode no carregamento');
}

Alpine.start();
