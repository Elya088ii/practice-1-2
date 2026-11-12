USE appDB;

-- Таблица для хранения сессий (Задание 1)
CREATE TABLE IF NOT EXISTS user_sessions (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    data TEXT NOT NULL,
    last_accessed INT UNSIGNED NOT NULL,
    INDEX idx_last_accessed (last_accessed)
) ENGINE=InnoDB;

-- Таблица для хранения PDF-файлов (Задание 3, вариант b: в БД)
CREATE TABLE IF NOT EXISTS pdf_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_data LONGBLOB NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица для пользователей (для персонализации)
CREATE TABLE IF NOT EXISTS marketplace_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    theme VARCHAR(20) DEFAULT 'light',
    language VARCHAR(10) DEFAULT 'ru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Тестовый пользователь (пароль: 12345)
INSERT IGNORE INTO marketplace_users (login, password_hash, theme, language) 
VALUES ('testuser', '$2y$10$YourHashHere', 'light', 'ru');