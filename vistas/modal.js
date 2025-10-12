
let modalShown = false;

function showModal() {
    if (localStorage.getItem('userLoggedIn') === 'true') return;

    const modal = document.getElementById('registrationModal');
    const modalContent = document.getElementById('modalContent');
    if (!modal || !modalContent) return;

    modal.style.display = 'flex';
    setTimeout(() => {
        modalContent.classList.add('show');
    }, 10);

    modalShown = true;
}

function hideModal() {
    const modal = document.getElementById('registrationModal');
    const modalContent = document.getElementById('modalContent');
    if (!modal || !modalContent) return;

    modalContent.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);

    modalShown = false;
}

function setUserLoggedIn() {
    localStorage.setItem('userLoggedIn', 'true');
}

function login() {
    setUserLoggedIn();
    window.location.href = 'Registrarse/login.html';
    hideModal();
}

function register() {
    setUserLoggedIn();
    window.location.href = 'registro.html';
    hideModal();
}

function forceModalOnInteraction() {
    document.addEventListener('scroll', () => {
        if (!modalShown && localStorage.getItem('userLoggedIn') !== 'true') showModal();
    });
    document.addEventListener('click', (e) => {
        const modal = document.getElementById('registrationModal');
        if (!modalShown && localStorage.getItem('userLoggedIn') !== 'true' && (!modal || !modal.contains(e.target))) {
            showModal();
        }
    });
}

function initModal() {
    showModal();
    forceModalOnInteraction();
}
document.addEventListener('DOMContentLoaded', initModal);