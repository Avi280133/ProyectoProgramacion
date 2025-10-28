<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Mensajería</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow: hidden;
        }

        .chat-container {
            display: flex;
            height: 100vh;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Sidebar de contactos */
        .sidebar {
            width: 380px;
            background: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px 25px;
        }

        .sidebar-header h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .search-bar {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .contacts-list {
            flex: 1;
            overflow-y: auto;
            background: #fafafa;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        .contact-item:hover {
            background: #f9fafb;
            transform: translateX(3px);
        }

        .contact-item.active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
            border-left: 4px solid #10b981;
        }

        .contact-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 20px;
            flex-shrink: 0;
            border: 3px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .contact-info {
            flex: 1;
            margin-left: 15px;
            min-width: 0;
        }

        .contact-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .contact-name {
            color: #374151;
            font-size: 16px;
            font-weight: 600;
        }

        .contact-time {
            color: #9ca3af;
            font-size: 12px;
        }

        .contact-message {
            color: #6b7280;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .unread-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 50%;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            margin-left: 10px;
            padding: 0 6px;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.4);
        }

        /* Área de chat */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .chat-user-info {
            flex: 1;
        }

        .chat-user-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        /* online status removed */

        .chat-header-icons {
            display: flex;
            gap: 20px;
            font-size: 20px;
            cursor: pointer;
        }

        .chat-messages {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            background: #fafafa;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            display: flex;
            gap: 10px;
            animation: messageSlide 0.3s ease-out;
        }

        @keyframes messageSlide {
            from {
                transform: translateY(10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .message.sent {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .received .message-avatar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .sent .message-avatar {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        }

        .message-content {
            max-width: 65%;
        }

        .message-bubble {
            padding: 13px 17px;
            border-radius: 18px;
            margin-bottom: 5px;
            position: relative;
            font-size: 15px;
            line-height: 1.5;
            word-wrap: break-word;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .received .message-bubble {
            background: white;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
            color: #374151;
        }

        .sent .message-bubble {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sent .message-time {
            justify-content: flex-end;
            color: white;
        }

        .received .message-time {
            color: #6b7280;
        }

        .date-divider {
            align-self: center;
            background: white;
            color: #6b7280;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            margin: 10px 0;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Input de mensaje */
        .chat-input {
            padding: 20px 25px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        .input-container {
            display: flex;
            gap: 12px;
            align-items: center;
            background: #f9fafb;
            border-radius: 25px;
            padding: 8px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .input-container:focus-within {
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .message-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 15px;
            font-size: 15px;
            outline: none;
            color: #374151;
        }

        .message-input::placeholder {
            color: #9ca3af;
        }

        .send-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.4);
        }

        .send-button:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 20px rgba(16, 185, 129, 0.5);
        }

        .send-button:active {
            transform: scale(0.98);
        }

        .contacts-list::-webkit-scrollbar,
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .contacts-list::-webkit-scrollbar-track,
        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .contacts-list::-webkit-scrollbar-thumb,
        .chat-messages::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .contacts-list::-webkit-scrollbar-thumb:hover,
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 320px;
            }
        }

        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: 40vh;
            }

            .message-content {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar de contactos -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Mensajes</h2>
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Buscar conversaciones..." id="contactSearch">
                </div>
            </div>

            <div class="contacts-list" id="contactsList">
                <!-- contactos se renderizan aquí dinámicamente -->
            </div>
        </div>

        <!-- Área de chat -->
        <div class="chat-area">
            <div class="chat-header" id="chatHeader">
                <!-- cabecera dinámica -->
                <div class="chat-avatar" id="chatAvatar">—</div>
                <div class="chat-user-info">
                    <div class="chat-user-name" id="chatUserName">Selecciona un contacto</div>
                </div>
            </div>

            <div class="chat-messages" id="chatMessages">
                <!-- mensajes se renderizan aquí -->
            </div>

            <div class="chat-input">
                <div class="input-container">
                    <input 
                        type="text" 
                        class="message-input" 
                        placeholder="Escribe tu mensaje..." 
                        id="messageInput"
                        onkeypress="handleKeyPress(event)"
                    >
                    <button class="send-button" id="sendBtn">→</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Datos de ejemplo (puedes reemplazarlos por datos del servidor)
    const contacts = [
        { id: 'juan', name: 'Juan', avatar: 'J', unread: 3, online: true },
        { id: 'maria', name: 'María González', avatar: 'M', unread: 0, online: false },
        { id: 'carlos', name: 'Carlos Pérez', avatar: 'C', unread: 0, online: true },
        { id: 'ana', name: 'Ana Martínez', avatar: 'A', unread: 1, online: false },
        { id: 'pedro', name: 'Pedro Rodríguez', avatar: 'P', unread: 0, online: false },
    ];

    // Conversaciones: mapa contactId -> array mensajes {from:'me'|'them', text, time}
    const conversations = {
        'juan': [
            { from: 'them', text: '¡Hola! ¿Cómo estás hoy?', time: '10:30 AM' },
            { from: 'me', text: '¡Hola Juan! Todo bien, ¿y tú?', time: '10:32 AM' },
        ],
        'maria': [
            { from: 'them', text: 'Nos vemos mañana entonces 👍', time: 'Ayer' },
        ],
        'carlos': [],
        'ana': [{ from: 'them', text: '¡Gracias por tu ayuda! 😊', time: 'Jue' }],
        'pedro': [{ from: 'them', text: 'OK, quedamos así entonces', time: 'Mié' }],
    };

    let currentContactId = null;

    const contactsListEl = document.getElementById('contactsList');
    const chatMessagesEl = document.getElementById('chatMessages');
    const chatUserNameEl = document.getElementById('chatUserName');
    const chatAvatarEl = document.getElementById('chatAvatar');
    const messageInputEl = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const contactSearch = document.getElementById('contactSearch');

    function formatTime(date = new Date()) {
        const h = date.getHours();
        const m = date.getMinutes().toString().padStart(2,'0');
        const ampm = h >= 12 ? 'PM' : 'AM';
        const hour12 = ((h + 11) % 12 + 1);
        return `${hour12}:${m} ${ampm}`;
    }

    function renderContacts(filter = '') {
        contactsListEl.innerHTML = '';
        const filtered = contacts.filter(c => c.name.toLowerCase().includes(filter.toLowerCase()));
        filtered.forEach(contact => {
            const item = document.createElement('div');
            item.className = 'contact-item' + (contact.id === currentContactId ? ' active' : '');
            item.onclick = () => loadChat(contact.id);

            const avatar = document.createElement('div');
            avatar.className = 'contact-avatar';
            avatar.textContent = contact.avatar;

            const info = document.createElement('div');
            info.className = 'contact-info';

            const header = document.createElement('div');
            header.className = 'contact-header';

            const name = document.createElement('span');
            name.className = 'contact-name';
            name.textContent = contact.name;

            const time = document.createElement('span');
            time.className = 'contact-time';
            // último mensaje time si existe
            const msgs = conversations[contact.id] || [];
            time.textContent = msgs.length ? msgs[msgs.length-1].time : '';

            header.appendChild(name);
            header.appendChild(time);

            const message = document.createElement('div');
            message.className = 'contact-message';
            message.textContent = (conversations[contact.id] && conversations[contact.id].length) ?
                conversations[contact.id].slice(-1)[0].text : 'Sin mensajes aún';

            info.appendChild(header);
            info.appendChild(message);

            item.appendChild(avatar);
            item.appendChild(info);

            if (contact.unread) {
                const badge = document.createElement('span');
                badge.className = 'unread-badge';
                badge.textContent = contact.unread;
                item.appendChild(badge);
            }

            contactsListEl.appendChild(item);
        });
    }

    function renderMessages(contactId) {
        chatMessagesEl.innerHTML = '';
        const msgs = conversations[contactId] || [];
        msgs.forEach(m => {
            const el = document.createElement('div');
            el.className = 'message ' + (m.from === 'me' ? 'sent' : 'received');
            el.innerHTML = `
                <div class="message-avatar">${m.from === 'me' ? 'Tú' : (contacts.find(c=>c.id===contactId)||{}).avatar || '?'}</div>
                <div class="message-content">
                    <div class="message-bubble">${escapeHtml(m.text)}</div>
                    <div class="message-time">${m.time}</div>
                </div>
            `;
            chatMessagesEl.appendChild(el);
        });
        chatMessagesEl.scrollTop = chatMessagesEl.scrollHeight;
    }

    function loadChat(contactId) {
        currentContactId = contactId;
        // marcar mensajes como leídos
        const contact = contacts.find(c => c.id === contactId);
        if (contact) contact.unread = 0;
        // actualizar header
        chatUserNameEl.textContent = contact ? contact.name : 'Sin contacto';
        chatAvatarEl.textContent = contact ? contact.avatar : '—';
    // online status removed
        renderContacts(contactSearch.value);
        renderMessages(contactId);
    }

    function sendMessage() {
        const text = messageInputEl.value.trim();
        if (!currentContactId || text === '') return;
        const time = formatTime();
        conversations[currentContactId] = conversations[currentContactId] || [];
        conversations[currentContactId].push({ from: 'me', text, time });
        // simular respuesta automática
        setTimeout(() => {
            conversations[currentContactId].push({ from: 'them', text: 'Respuesta automática', time: formatTime() });
            renderMessages(currentContactId);
            renderContacts(contactSearch.value);
        }, 800);
        messageInputEl.value = '';
        renderMessages(currentContactId);
        renderContacts(contactSearch.value);
    }

    function escapeHtml(text) {
        const map = { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }


    // event listeners
    sendBtn.addEventListener('click', sendMessage);
    contactSearch.addEventListener('input', (e) => renderContacts(e.target.value));
    // edit contact button removed
    function handleKeyPress(event) {
        if (event.key === 'Enter') sendMessage();
    }

    // init
    renderContacts();
    // seleccionar primer contacto por defecto
    if (contacts.length) loadChat(contacts[0].id);
    </script>
</body>
</html>