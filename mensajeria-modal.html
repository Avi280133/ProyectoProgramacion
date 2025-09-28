<div class="modal-overlay-chat" id="modalOverlay" onclick="closeChat()"></div>

    <div class="chat-modal" id="chatModal">
        <div class="chat-header" onclick="closeChat()">
            <div class="drag-indicator"></div>
            <div class="modal-avatar">J</div>
            <div class="modal-user-details">
                <h3>Juan</h3>
                <div class="modal-user-status">
                    <div class="status-dot"></div>
                    En línea
                </div>
            </div>
            <div class="close-hint">Toca para cerrar</div>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="message received">
                <div class="message-avatar">J</div>
                <div class="message-content">
                    <div class="message-bubble">
                        ¡Hola! ¿Cómo estás hoy?
                    </div>
                    <div class="message-time">10:30 AM</div>
                </div>
            </div>

            <div class="message sent">
                <div class="message-avatar">Tú</div>
                <div class="message-content">
                    <div class="message-bubble">
                        ¡Hola Juan! Todo bien, ¿y tú?
                    </div>
                    <div class="message-time">10:32 AM</div>
                </div>
            </div>

            <div class="message received">
                <div class="message-avatar">J</div>
                <div class="message-content">
                    <div class="message-bubble">
                        Excelente, trabajando en algunos proyectos nuevos. ¿Te gustaría que te cuente?
                    </div>
                    <div class="message-time">10:35 AM</div>
                </div>
            </div>
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
                <button class="send-button" onclick="sendMessage()">→</button>
            </div>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .message-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .message-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .message-button:active {
            transform: translateY(0);
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .chat-modal {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            width: 90%;
            max-width: 500px;
            height: 70vh;
            max-height: 600px;
            min-height: 500px;
            background: white;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            display: flex;
            flex-direction: column;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .chat-modal.active {
            transform: translateX(-50%) translateY(0);
        }
        
        .chat-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-radius: 20px 20px 0 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .chat-header:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .drag-indicator {
            width: 40px;
            height: 4px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 2px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .modal-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .modal-user-details h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .modal-user-status {
            font-size: 13px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .close-hint {
            margin-left: auto;
            font-size: 12px;
            opacity: 0.8;
            font-style: italic;
        }
        

        .chat-messages {
            flex: 1;
            padding: 20px;
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
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .received .message-avatar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .sent .message-avatar {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        }
        
        .message-content {
            max-width: 75%;
        }
        
        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            margin-bottom: 4px;
            position: relative;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .received .message-bubble {
            background: white;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
            color: #374151;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.08);
        }
        
        .sent .message-bubble {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 1px 8px rgba(16, 185, 129, 0.3);
        }
        
        .message-time {
            font-size: 11px;
            opacity: 0.6;
        }
        
        .sent .message-time {
            text-align: right;
        }
        
        .chat-input {
            padding: 20px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }
        
        .input-container {
            display: flex;
            gap: 10px;
            align-items: center;
            background: #f9fafb;
            border-radius: 25px;
            padding: 6px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .input-container:focus-within {
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .message-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 15px;
            font-size: 14px;
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
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .send-button:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.4);
        }
        
        .chat-messages::-webkit-scrollbar {
            width: 4px;
        }
        
        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .chat-messages::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 2px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
        
        @media (max-width: 768px) {
            .chat-modal {
                width: 100%;
                height: 85vh;
            }
            
            .profile-card {
                margin: 20px;
                padding: 30px;
            }
            
            .message-content {
                max-width: 80%;
            }
        }
    </style>
    <script src="mensajeria-modal.js"></script>
