-- Dump para TaskManager
CREATE DATABASE IF NOT EXISTS taskmanager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taskmanager;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  birth_date DATE,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  due_date DATETIME,
  status ENUM('open','done') DEFAULT 'open',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Exemplo de usuário para testes (senha: Teste@123)
INSERT INTO users (first_name, last_name, birth_date, username, password_hash)
VALUES ('Teste','Dev','1990-01-01','teste', '$2y$10$abcdefghijklmnopqrstuvwx0123456789ABCDEFGHijklmnopqr'); 
-- OBS: substitua o hash por um real usando password_hash no PHP ou delete esta linha e crie via frontend.
