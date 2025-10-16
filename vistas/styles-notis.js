const NotificationsModal = (function() {
    let notifications = [];
    let currentTab = 'all';
    
    const elements = {
        modal: null,
        body: null,
        markAllBtn: null,
        viewAllBtn: null,
        tabs: null
    };

    function init() {
        elements.modal = document.getElementById('notifModal');
        elements.body = document.getElementById('notifBody');
        elements.markAllBtn = document.getElementById('markAllBtn');
        elements.viewAllBtn = document.getElementById('viewAllBtn');
        elements.tabs = document.querySelectorAll('.tab-btn');

        // Event listeners
        elements.markAllBtn.addEventListener('click', markAllAsRead);
        elements.viewAllBtn.addEventListener('click', viewAll);

        elements.tabs.forEach(tab => {
            tab.addEventListener('click', () => switchTab(tab.dataset.tab));
        });

        // Cerrar con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && elements.modal.classList.contains('active')) {
                close();
            }
        });

        loadSampleNotifications();
    }

    function loadSampleNotifications() {
        notifications = [
            {
                id: 1,
                type: 'message',
                title: 'Nuevo mensaje de Juan Pérez',
                message: 'Hola, me interesa tu servicio de reparación...',
                time: 'Hace 5 min',
                unread: true
            },
            {
                id: 2,
                type: 'rating',
                title: 'Nueva calificación ⭐⭐⭐⭐⭐',
                message: 'María González te ha dado 5 estrellas',
                time: 'Hace 2 horas',
                unread: true
            },
            {
                id: 3,
                type: 'payment',
                title: 'Pago recibido - $250.00',
                message: 'Instalación Eléctrica Residencial',
                time: 'Hace 5 horas',
                unread: true
            },
            {
                id: 4,
                type: 'alert',
                title: 'Servicio por expirar',
                message: 'Tu publicación expira en 3 días',
                time: 'Hace 1 día',
                unread: false
            },
            {
                id: 5,
                type: 'success',
                title: 'Servicio publicado',
                message: 'Plomería 24/7 está visible para clientes',
                time: 'Hace 3 días',
                unread: true
            },
            {
                id: 6,
                type: 'info',
                title: 'Actualización disponible',
                message: 'Nuevas funcionalidades en la plataforma',
                time: 'Hace 1 semana',
                unread: false
            }
        ];

        renderNotifications();
    }

    function renderNotifications() {
        const filtered = getFilteredNotifications();
        
        elements.body.innerHTML = '';

        if (filtered.length === 0) {
            showEmptyState();
            return;
        }

        filtered.forEach(notification => {
            const item = createNotificationElement(notification);
            elements.body.appendChild(item);
        });
    }

    function createNotificationElement(notification) {
        const div = document.createElement('div');
        div.className = `notification-item type-${notification.type}`;
        div.dataset.id = notification.id;
        
        if (notification.unread) {
            div.classList.add('unread');
        }

        const iconMap = {
            message: 'fa-message',
            rating: 'fa-star',
            payment: 'fa-dollar-sign',
            alert: 'fa-exclamation-triangle',
            info: 'fa-info-circle',
            success: 'fa-check-circle'
        };

        div.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fa-solid ${iconMap[notification.type]}"></i>
                </div>
                <div class="notification-text">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">
                        <i class="fa-regular fa-clock"></i>
                        ${notification.time}
                    </div>
                </div>
            </div>
        `;

        div.addEventListener('click', () => handleNotificationClick(notification.id));

        return div;
    }

    function handleNotificationClick(id) {
        const notification = notifications.find(n => n.id === id);
        
        if (notification && notification.unread) {
            notification.unread = false;
            renderNotifications();
        }

        // Aquí puedes agregar lógica adicional
        console.log('Notificación clickeada:', id);
        showToast('Notificación marcada como leída');
        
        // Ejemplo para enviar al backend:
        // fetch('api/mark-read.php', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ notificationId: id })
        // });
    }

    function showEmptyState() {
        elements.body.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <div class="empty-title">No hay notificaciones</div>
                <div class="empty-text">
                    Cuando recibas nuevas notificaciones<br>aparecerán aquí
                </div>
            </div>
        `;
    }

    function getFilteredNotifications() {
        if (currentTab === 'unread') {
            return notifications.filter(n => n.unread);
        }
        return notifications;
    }

    function switchTab(tab) {
        currentTab = tab;
        
        elements.tabs.forEach(t => {
            if (t.dataset.tab === tab) {
                t.classList.add('active');
            } else {
                t.classList.remove('active');
            }
        });

        renderNotifications();
    }

    function markAllAsRead() {
        const unreadCount = notifications.filter(n => n.unread).length;
        
        if (unreadCount === 0) {
            showToast('No hay notificaciones sin leer');
            return;
        }

        notifications.forEach(n => n.unread = false);
        renderNotifications();
        showToast(`${unreadCount} notificaciones marcadas como leídas`);
        
        // Enviar al backend:
        // fetch('api/mark-all-read.php', { method: 'POST' });
    }

    function open() {
        elements.modal.classList.add('active');
        renderNotifications();
    }

    function close() {
        elements.modal.classList.remove('active');
    }

    function toggle() {
        if (elements.modal.classList.contains('active')) {
            close();
        } else {
            open();
        }
    }

    function viewAll() {
        alert('Redirigiendo a página completa de notificaciones...');
        // window.location.href = 'notificaciones.php';
    }

    function showToast(message) {
        const existingToast = document.querySelector('.toast');
        if (existingToast) existingToast.remove();

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <i class="fa-solid fa-check-circle"></i>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }

    function addNotification(notification) {
        notifications.unshift({
            id: Date.now(),
            ...notification,
            unread: true
        });
        
        if (elements.modal.classList.contains('active')) {
            renderNotifications();
        }
        
        showToast('Nueva notificación recibida');
    }

    function loadNotificationsFromServer() {
        // Ejemplo de carga desde PHP
        fetch('api/get-notifications.php')
            .then(response => response.json())
            .then(data => {
                notifications = data;
                renderNotifications();
            })
            .catch(error => {
                console.error('Error cargando notificaciones:', error);
            });
    }

    return {
        init,
        open,
        close,
        toggle,
        addNotification,
        loadNotificationsFromServer,
        getUnreadCount: () => notifications.filter(n => n.unread).length
    };
})();

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    NotificationsModal.init();
});