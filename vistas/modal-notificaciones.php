<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Modal Compacto */
.notifications-modal {
    position: absolute;
    top: calc(100% + 15px);
    right: 0;
    width: 380px;
    max-height: 500px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.95);
    transform-origin: top right;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.notifications-modal.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Flecha del modal */
.notifications-modal::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 18px;
    width: 16px;
    height: 16px;
    background: white;
    transform: rotate(45deg);
    box-shadow: -3px -3px 5px rgba(0, 0, 0, 0.05);
}

/* Header */
.modal-header {
    background: linear-gradient(135deg, #025939 0%, #0eb27c 100%);
    padding: 20px;
    color: white;
    position: relative;
    z-index: 1;
}

.modal-header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.1rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mark-all-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.mark-all-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Tabs */
.modal-tabs {
    display: flex;
    gap: 6px;
    margin-top: 12px;
}

.tab-btn {
    flex: 1;
    padding: 6px 12px;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 0.8rem;
}

.tab-btn.active {
    background: white;
    color: #025939;
}

/* Body */
.modal-body {
    flex: 1;
    overflow-y: auto;
    max-height: 380px;
}

.modal-body::-webkit-scrollbar {
    width: 4px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #0eb27c;
    border-radius: 10px;
}

/* Notification Item */
.notification-item {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    opacity: 0;
    animation: fadeInUp 0.4s ease forwards;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-item.unread {
    background: #f0fdf4;
}

.notification-item.unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 3px;
    height: 100%;
    background: #0eb27c;
}

.notification-item.unread::after {
    content: '';
    position: absolute;
    right: 16px;
    top: 20px;
    width: 8px;
    height: 8px;
    background: #0eb27c;
    border-radius: 50%;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-item:nth-child(1) { animation-delay: 0.05s; }
.notification-item:nth-child(2) { animation-delay: 0.1s; }
.notification-item:nth-child(3) { animation-delay: 0.15s; }
.notification-item:nth-child(4) { animation-delay: 0.2s; }
.notification-item:nth-child(5) { animation-delay: 0.25s; }

.notification-content {
    display: flex;
    gap: 12px;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

/* Icon Types */
.notification-item.type-message .notification-icon {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.notification-item.type-rating .notification-icon {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
}

.notification-item.type-payment .notification-icon {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #059669;
}

.notification-item.type-alert .notification-icon {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
}

.notification-item.type-info .notification-icon {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #4f46e5;
}

.notification-item.type-success .notification-icon {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #10b981;
}

.notification-text {
    flex: 1;
}

.notification-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 4px;
    line-height: 1.3;
}

.notification-message {
    font-size: 0.78rem;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.notification-time {
    font-size: 0.72rem;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
    text-align: center;
    color: #94a3b8;
}

.empty-icon {
    font-size: 3rem;
    color: #e2e8f0;
    margin-bottom: 12px;
}

.empty-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 6px;
}

.empty-text {
    font-size: 0.8rem;
    line-height: 1.4;
}

/* Footer */
.modal-footer {
    padding: 12px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.view-all-btn {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(14, 178, 124, 0.3);
}

/* Responsive */
@media (max-width: 480px) {
    .notifications-modal {
        width: 320px;
        max-height: 450px;
    }

    .modal-body {
        max-height: 330px;
    }
}

/* Toast Notifications */
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #10b981;
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 10000;
    animation: slideInUp 0.3s ease;
}

.toast.hide {
    animation: slideOutDown 0.3s ease forwards;
}

@keyframes slideInUp {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideOutDown {
    to {
        transform: translateY(100px);
        opacity: 0;
    }
}
    </style>
</head>
<body>
    <!-- Modal de Notificaciones -->
<div class="notifications-modal" id="notifModal">
    <!-- Header -->
    <div class="modal-header">
        <div class="modal-header-top">
            <div class="modal-title">
                <i class="fa-solid fa-bell"></i>
                Notificaciones
            </div>
            <button class="mark-all-btn" id="markAllBtn">
                <i class="fa-solid fa-check-double"></i> Marcar leídas
            </button>
        </div>
        <div class="modal-tabs">
            <button class="tab-btn active" data-tab="all">Todas</button>
            <button class="tab-btn" data-tab="unread">Sin leer</button>
        </div>
    </div>

    <!-- Body -->
    <div class="modal-body" id="notifBody">
        <!-- Las notificaciones se cargarán aquí -->
    </div>

    <!-- Footer -->
    <div class="modal-footer">
        <button class="view-all-btn" id="viewAllBtn">
            Ver todas las notificaciones
            <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
        </button>
    </div>
</div>

<script src="></script>
</body>
</html>