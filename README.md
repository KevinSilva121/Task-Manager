# TaskManager

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Aplicação web de gerenciamento de tarefas construída com PHP e MySQL no backend e Vue.js com Bootstrap no frontend. Implementa autenticação via JWT e uma API REST completa para operações CRUD de tarefas.

---

## Índice

- [Visão Geral](#visão-geral)
- [Tecnologias](#tecnologias)
- [Arquitetura](#arquitetura)
- [Instalação e Configuração](#instalação-e-configuração)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [API Endpoints](#api-endpoints)
- [Autenticação](#autenticação)
- [Banco de Dados](#banco-de-dados)
- [Configuração](#configuração)
- [Acesso Remoto](#acesso-remoto)
- [Troubleshooting](#troubleshooting)
- [Segurança](#segurança)

---

## Visão Geral

O TaskManager é uma aplicação full-stack que permite aos usuários:

- **Registro e autenticação** de usuários com JWT
- **Gerenciamento de tarefas** (criar, editar, deletar, marcar como concluída)
- **Interface responsiva** e moderna
- **API REST** completa e documentada
- **Autenticação stateless** usando JSON Web Tokens

### Resumo Rápido

| Componente | Tecnologia | Descrição |
|------------|-----------|-----------|
| **Backend** | PHP 7.4+ | APIs REST para autenticação e gerenciamento de tarefas |
| **Frontend** | Vue.js 3 | Interface reativa e moderna |
| **Banco de Dados** | MySQL 5.7+ | Armazenamento de dados de usuários e tarefas |
| **Autenticação** | JWT | Autenticação stateless e segura |
| **Estilos** | Bootstrap 5 | Framework CSS responsivo |

---

## Tecnologias

### Backend

- **PHP 7.4+** - Linguagem de programação server-side
- **MySQL 5.7+** - Sistema de gerenciamento de banco de dados relacional
- **Apache** - Servidor web HTTP
- **JWT** - Autenticação baseada em tokens

### Frontend

- **Vue.js 3** - Framework JavaScript progressivo
- **Bootstrap 5.3.0** - Framework CSS para design responsivo
- **Font Awesome 6.4.0** - Biblioteca de ícones
- **JavaScript (ES6+)** - Linguagem de programação client-side

### Ferramentas

- **XAMPP** - Ambiente de desenvolvimento local
- **phpMyAdmin** - Interface web para gerenciamento do MySQL
- **Composer** (opcional) - Gerenciador de dependências PHP

---

## Arquitetura

### Estrutura Geral

```
TaskManager/
│
├── backend/                 # API REST (PHP)
│   ├── config.php          # Configurações do banco e JWT
│   ├── db.php              # Conexão com banco de dados
│   ├── jwt.php             # Funções JWT (criar/verificar tokens)
│   ├── auth_middleware.php # Middleware de autenticação
│   ├── cors.php            # Configuração CORS
│   ├── login.php           # Endpoint de login
│   ├── register.php        # Endpoint de registro
│   ├── tasks.php           # Endpoint CRUD de tarefas
│   └── dump.sql            # Schema do banco de dados
│
└── frontend/               # Interface do usuário
    ├── index.html          # Página de login/registro
    ├── app.html            # Página principal (lista de tarefas)
    ├── credits.html        # Página de créditos
    └── assets/
        └── style.css       # Estilos customizados
```

### Fluxo de Dados

```
Frontend (Vue.js) 
    ↓ HTTP Request
Backend (PHP) 
    ↓ PDO
MySQL Database
    ↓ Response
Backend (PHP)
    ↓ JSON Response
Frontend (Vue.js)
```

### Autenticação

1. Usuário faz login através de `login.php`
2. Backend valida credenciais e gera token JWT
3. Frontend armazena token no `localStorage`
4. Todas as requisições subsequentes incluem token no header `Authorization: Bearer <token>`
5. Middleware `auth_middleware.php` valida o token em cada requisição

---

## Instalação e Configuração

### Pré-requisitos

- XAMPP instalado (Apache, MySQL, PHP)
- Navegador web moderno
- Editor de código (opcional)

### Passo a Passo

#### 1. Clonar/Baixar o Projeto

Coloque a pasta do projeto dentro do diretório `htdocs` do XAMPP:

```
C:\xampp\htdocs\TaskManager
```

**Nota:** O nome da pasta pode ser qualquer um. O sistema detecta automaticamente o caminho correto.

#### 2. Iniciar Serviços no XAMPP

1. Abra o **Painel de Controle do XAMPP**
2. Inicie os seguintes serviços:
   - **Apache**
   - **MySQL**

#### 3. Configurar Banco de Dados

1. Acesse o phpMyAdmin: `http://localhost/phpmyadmin`
2. Importe o arquivo `backend/dump.sql`:
   - Clique em "Importar"
   - Selecione o arquivo `backend/dump.sql`
   - Clique em "Executar"

**Alternativa:** Crie o banco manualmente:
```sql
CREATE DATABASE taskmanager;
USE taskmanager;
-- Importe o conteúdo do dump.sql
```

#### 4. Configurar Credenciais do Banco

Edite o arquivo `backend/config.php`:

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'taskmanager');
define('DB_USER', 'root');        // Usuário do MySQL
define('DB_PASS', '');            // Senha do MySQL (vazio por padrão no XAMPP)
```

#### 5. Configurar Chave JWT (Recomendado)

Edite o arquivo `backend/config.php` e altere a chave secreta:

```php
define('JWT_SECRET', 'sua_chave_secreta_aqui_muito_forte_e_aleatoria');
```

**Importante:** Use uma chave forte e aleatória em produção.

#### 6. Acessar a Aplicação

Abra o navegador e acesse:

```
http://localhost/TaskManager/frontend/index.html
```

Ou, se você usou outro nome para a pasta:

```
http://localhost/[nome-da-pasta]/frontend/index.html
```

---

## Estrutura do Projeto

### Backend

| Arquivo | Descrição |
|---------|-----------|
| `config.php` | Configurações do banco de dados e JWT |
| `db.php` | Função `getPDO()` para conexão com banco |
| `jwt.php` | Funções `jwt_create()` e `jwt_verify()` |
| `auth_middleware.php` | Funções `require_auth()` e `getBearerToken()` |
| `cors.php` | Configuração de cabeçalhos CORS |
| `login.php` | Endpoint POST para autenticação |
| `register.php` | Endpoint POST para registro de usuários |
| `tasks.php` | Endpoint REST para CRUD de tarefas |
| `dump.sql` | Schema do banco de dados |

### Frontend

| Arquivo | Descrição |
|---------|-----------|
| `index.html` | Página de login e registro |
| `app.html` | Página principal com lista de tarefas |
| `credits.html` | Página de créditos e informações |
| `assets/style.css` | Estilos customizados da aplicação |

---

## API Endpoints

### Autenticação

#### POST `/backend/register.php`

Registra um novo usuário.

**Request Body:**
```json
{
  "first_name": "João",
  "last_name": "Silva",
  "birth_date": "1990-01-01",
  "username": "joaosilva",
  "password": "senha123"
}
```

**Response (201):**
```json
{
  "message": "User created",
  "user_id": 1
}
```

#### POST `/backend/login.php`

Autentica um usuário e retorna token JWT.

**Request Body:**
```json
{
  "username": "joaosilva",
  "password": "senha123"
}
```

**Response (200):**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "user_id": 1,
    "username": "joaosilva",
    "name": "João Silva"
  }
}
```

### Tarefas

Todos os endpoints de tarefas requerem autenticação via token JWT no header:

```
Authorization: Bearer <token>
```

#### GET `/backend/tasks.php`

Lista todas as tarefas do usuário autenticado.

**Response (200):**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "title": "Tarefa exemplo",
    "description": "Descrição da tarefa",
    "created_at": "2024-01-01 10:00:00",
    "due_date": "2024-01-15 23:59:59",
    "status": "open"
  }
]
```

#### GET `/backend/tasks.php?id=1`

Obtém uma tarefa específica.

**Response (200):**
```json
{
  "id": 1,
  "user_id": 1,
  "title": "Tarefa exemplo",
  "description": "Descrição da tarefa",
  "created_at": "2024-01-01 10:00:00",
  "due_date": "2024-01-15 23:59:59",
  "status": "open"
}
```

#### POST `/backend/tasks.php`

Cria uma nova tarefa.

**Request Body:**
```json
{
  "title": "Nova tarefa",
  "description": "Descrição opcional",
  "due_date": "2024-01-15 23:59:59"
}
```

**Response (201):**
```json
{
  "message": "created",
  "id": 1
}
```

#### PUT `/backend/tasks.php`

Atualiza uma tarefa existente.

**Request Body:**
```json
{
  "id": 1,
  "title": "Tarefa atualizada",
  "description": "Nova descrição",
  "due_date": "2024-01-20 23:59:59",
  "status": "done"
}
```

**Response (200):**
```json
{
  "message": "updated"
}
```

#### DELETE `/backend/tasks.php?id=1`

Deleta uma tarefa.

**Response (200):**
```json
{
  "message": "deleted"
}
```

---

## Autenticação

### JWT (JSON Web Tokens)

A aplicação utiliza JWT para autenticação stateless. O token contém:

- `user_id`: ID do usuário
- `username`: Nome de usuário
- `name`: Nome completo do usuário
- `iat`: Data de criação (issued at)
- `exp`: Data de expiração

### Configuração

As configurações de JWT estão em `backend/config.php`:

```php
define('JWT_SECRET', 'sua_chave_secreta');
define('JWT_EXPIRY', 3600); // Tempo de expiração em segundos (1 hora)
```

### Fluxo de Autenticação

1. **Login:** Usuário envia credenciais para `login.php`
2. **Validação:** Backend valida credenciais no banco de dados
3. **Token:** Backend gera token JWT e retorna para o frontend
4. **Armazenamento:** Frontend armazena token no `localStorage`
5. **Requisições:** Todas as requisições incluem token no header `Authorization`
6. **Validação:** Middleware valida token em cada requisição protegida

### Headers Requeridos

Para endpoints protegidos, inclua o header:

```
Authorization: Bearer <token>
```

---

## Banco de Dados

### Schema

#### Tabela `users`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT | Chave primária, auto incremento |
| `first_name` | VARCHAR(100) | Nome do usuário |
| `last_name` | VARCHAR(100) | Sobrenome do usuário |
| `birth_date` | DATE | Data de nascimento |
| `username` | VARCHAR(50) | Nome de usuário (único) |
| `password_hash` | VARCHAR(255) | Hash da senha (bcrypt) |
| `created_at` | TIMESTAMP | Data de criação |

#### Tabela `tasks`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT | Chave primária, auto incremento |
| `user_id` | INT | Chave estrangeira para `users.id` |
| `title` | VARCHAR(255) | Título da tarefa |
| `description` | TEXT | Descrição da tarefa (opcional) |
| `created_at` | TIMESTAMP | Data de criação |
| `due_date` | DATETIME | Data de vencimento (opcional) |
| `status` | ENUM('open', 'done') | Status da tarefa |

### Relacionamentos

- `tasks.user_id` → `users.id` (Foreign Key)
- Um usuário pode ter várias tarefas
- Uma tarefa pertence a um único usuário

---

## Configuração

### Variáveis de Ambiente

Edite o arquivo `backend/config.php`:

```php
// Configurações do Banco de Dados
define('DB_HOST', '127.0.0.1');      // Host do MySQL
define('DB_NAME', 'taskmanager');    // Nome do banco de dados
define('DB_USER', 'root');           // Usuário do MySQL
define('DB_PASS', '');               // Senha do MySQL

// Configurações JWT
define('JWT_SECRET', 'sua_chave_secreta_aqui');
define('JWT_EXPIRY', 3600);          // Expiração em segundos (1 hora)
```

### CORS

O arquivo `backend/cors.php` configura os cabeçalhos CORS:

```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
```

**Nota:** Em produção, substitua `*` pelo domínio específico da aplicação.

---

## Acesso Remoto

Para acessar a aplicação de outro computador na mesma rede:

### 1. Descobrir IP do Servidor

**Windows:**
```cmd
ipconfig
```
Procure pelo "IPv4 Address" (ex: `192.168.1.100`)

**Linux/Mac:**
```bash
ifconfig
# ou
ip addr
```

### 2. Configurar Firewall

**Windows:**
1. Abra "Firewall do Windows Defender"
2. Clique em "Configurações Avançadas"
3. Crie nova regra de entrada para porta 80 (HTTP)
4. Permita conexões TCP

### 3. Acessar Aplicação

Use o IP do servidor no lugar de `localhost`:

```
http://192.168.1.100/TaskManager/frontend/index.html
```

### Verificações Importantes

- Apache e MySQL devem estar rodando no servidor
- Ambos os PCs devem estar na mesma rede
- O MySQL não precisa aceitar conexões remotas (PHP roda no servidor)
- O `DB_HOST` deve permanecer como `127.0.0.1` no servidor

---

## Troubleshooting

### Problema: "Fica na tela de login" ou "Erro de conexão com banco de dados"

#### Solução 1: Verificar Serviços do XAMPP

1. Abra o painel do XAMPP
2. Verifique se Apache e MySQL estão com status "Running" (verde)
3. Se não estiverem, inicie os serviços

#### Solução 2: Verificar Banco de Dados

1. Acesse: `http://localhost/phpmyadmin`
2. Verifique se existe o banco `taskmanager`
3. Se não existir, importe o arquivo `backend/dump.sql`

#### Solução 3: Verificar Credenciais

Edite `backend/config.php` e verifique:

```php
define('DB_NAME', 'taskmanager');  // Nome do banco
define('DB_USER', 'root');         // Usuário (padrão XAMPP)
define('DB_PASS', '');             // Senha (vazio por padrão)
define('DB_HOST', '127.0.0.1');    // Host (localhost)
```

#### Solução 4: Verificar URL de Acesso

Use exatamente o nome da pasta que está em `htdocs`:

- Se a pasta é `task`: `http://localhost/task/frontend/index.html`
- Se a pasta é `TaskManager`: `http://localhost/TaskManager/frontend/index.html`

#### Solução 5: Verificar Backend

Teste se o backend está respondendo:

1. Acesse: `http://localhost/[SUA_PASTA]/backend/login.php`
2. Se aparecer um erro JSON, o backend está funcionando
3. Se aparecer erro 404, verifique o caminho da pasta

#### Solução 6: Verificar Console do Navegador

1. Abra as Ferramentas de Desenvolvedor (F12)
2. Vá na aba "Console" e verifique erros JavaScript
3. Vá na aba "Network" e verifique se as requisições estão falhando

### Problema: Acesso Remoto Não Funciona

- Verifique se o firewall está bloqueando a porta 80
- Teste se o Apache responde localmente no servidor primeiro
- Certifique-se de que ambos os PCs estão na mesma rede
- Use o mesmo nome da pasta no servidor e na URL de acesso

---

## Segurança

### Recomendações

1. **JWT Secret:** Altere a chave `JWT_SECRET` para uma string forte e aleatória
2. **CORS:** Em produção, restrinja o CORS para o domínio específico da aplicação
3. **HTTPS:** Use HTTPS em produção para criptografar as comunicações
4. **Senhas:** O backend usa `password_hash()` e `password_verify()` (bcrypt)
5. **Tokens:** Tokens expiram conforme `JWT_EXPIRY` configurado
6. **Dump SQL:** Não exponha `dump.sql` com hashes reais em repositórios públicos

### Boas Práticas

- Use senhas fortes para usuários
- Não compartilhe tokens JWT
- Mantenha o `JWT_SECRET` seguro e não versionado
- Valide todos os dados de entrada no backend
- Use prepared statements (PDO) para prevenir SQL injection

---

## Funcionalidades

### Funcionalidades Implementadas

- Registro de usuários
- Login com JWT
- Criação de tarefas
- Edição de tarefas
- Exclusão de tarefas
- Marcar tarefas como concluídas
- Listagem de tarefas do usuário
- Alertas de tarefas atrasadas
- Interface responsiva
- Validação de autenticação

### Funcionalidades Futuras (Sugestões)

- Filtros de tarefas (por status, data)
- Busca de tarefas
- Categorias de tarefas
- Prioridades de tarefas
- Compartilhamento de tarefas
- Notificações por email
- Exportação de tarefas (PDF, CSV)

---

## Notas Finais

Esta é uma aplicação educativa e funcional para gerenciamento de tarefas com autenticação JWT e API REST. O código está organizado de forma clara e pode ser usado como base para projetos maiores.

### Licença

Este projeto é de código aberto e pode ser usado livremente para fins educacionais.

### Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para:

- Reportar bugs
- Sugerir melhorias
- Enviar pull requests
- Melhorar a documentação

---

**Desenvolvido com PHP, MySQL, Vue.js e Bootstrap**
