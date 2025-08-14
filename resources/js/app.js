import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    if(openBtn) {
        openBtn.addEventListener('click', e => {
            e.preventDefault();
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        });
    }

    if(closeBtn) {
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('translate-x-full');
            document.body.style.overflow = '';
        });
    }
});

