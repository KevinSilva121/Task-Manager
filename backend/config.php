<?php
// config.php
// Ajuste conforme seu MySQL (usuário/senha)
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'taskmanager');
define('DB_USER', 'root');
define('DB_PASS', ''); // se você usa senha, coloque aqui

// JWT secret (mantenha seguro em produção)
define('JWT_SECRET', 'troque_esta_chave_para_alguma_mais_secreta_123!');

// token expiration em segundos (ex: 1 hora)
define('JWT_EXPIRY', 3600);
