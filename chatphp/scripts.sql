-- Crear tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Crear tabla de mensajes
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único de la notificación
    user_id INT NOT NULL,              -- ID del usuario que recibe la notificación
    --message TEXT NOT NULL,             -- Contenido de la notificación
    is_read BOOLEAN DEFAULT FALSE,     -- Estado de la notificación (leída o no)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de creación
    FOREIGN KEY (user_id) REFERENCES users(id)     -- Relación con la tabla de usuarios
);