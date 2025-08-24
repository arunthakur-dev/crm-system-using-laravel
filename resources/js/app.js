import './bootstrap';

// Create sidebar Js
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


// Edit Sidebar Js

document.addEventListener('DOMContentLoaded', () => {
    const editSidebar = document.getElementById('editSidebar');
    const openEditBtn = document.getElementById('openEditSidebar');
    const closeEditBtn = document.getElementById('closeEditSidebar');

    if(openEditBtn) {
        openEditBtn.addEventListener('click', e => {
            e.preventDefault();
            editSidebar.classList.remove('translate-x-full');
            editSidebar.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        });
    }

    if(closeEditBtn) {
        closeEditBtn.addEventListener('click', () => {
            editSidebar.classList.remove('translate-x-0');
            editSidebar.classList.add('translate-x-full');
            document.body.style.overflow = '';
        });
    }
});



