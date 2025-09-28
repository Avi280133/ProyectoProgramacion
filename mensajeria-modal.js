let chatOpen = false;

function openChat() {
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('chatModal');
    const mainContent = document.getElementById('mainContent');
    
    overlay.classList.add('active');
    modal.classList.add('active');
    if (mainContent) mainContent.classList.add('blurred');
    chatOpen = true;
    
    setTimeout(() => {
        document.getElementById('messageInput').focus();
    }, 400);
}

function closeChat() {
    if (!chatOpen) return;
    
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('chatModal');
    const mainContent = document.getElementById('mainContent');
    
    overlay.classList.remove('active');
    modal.classList.remove('active');
    if (mainContent) mainContent.classList.remove('blurred');
    chatOpen = false;
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (message) {
        const chatMessages = document.getElementById('chatMessages');
        const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message sent';
        messageDiv.innerHTML = `
            <div class="message-avatar">Tú</div>
            <div class="message-content">
                <div class="message-bubble">${message}</div>
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        input.value = '';
        
        setTimeout(() => {
            simulateResponse();
        }, 800 + Math.random() * 1500);
    }
}

function simulateResponse() {
    const responses = [
        "¡Interesante!",
        "Me parece genial",
        "¿Podrías contarme más?",
        "Totalmente de acuerdo",
        "Eso suena muy bien",
        "Qué buena idea",
        "Perfecto, me gusta",
        "¡Claro que sí!"
    ];
    
    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
    const chatMessages = document.getElementById('chatMessages');
    const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message received';
    messageDiv.innerHTML = `
        <div class="message-avatar">J</div>
        <div class="message-content">
            <div class="message-bubble">${randomResponse}</div>
            <div class="message-time">${currentTime}</div>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && chatOpen) {
        closeChat();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const chatModal = document.getElementById('chatModal');
    if (chatMessages) {
        chatMessages.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    if (chatModal) {
        chatModal.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});