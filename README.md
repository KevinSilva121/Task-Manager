# TaskManager

Aplicação simples de gerenciamento de tarefas construída com PHP + MySQL no backend e Vue.js + Bootstrap no frontend. Fornece autenticação via JWT e uma API REST para CRUD de tarefas.

Resumo rápido
- Backend: PHP (APIs REST) — [backend/login.php](backend/login.php), [backend/register.php](backend/register.php), [backend/tasks.php](backend/tasks.php)
- Frontend: páginas estáticas em [frontend/](frontend/) usando Vue 3 e Bootstrap — [frontend/index.html](frontend/index.html), [frontend/app.html](frontend/app.html), [frontend/credits.html](frontend/credits.html)
- Banco de dados: MySQL — esquema em [backend/dump.sql](backend/dump.sql)
- Arquivos de suporte: [backend/config.php](backend/config.php), [backend/db.php](backend/db.php), [backend/jwt.php](backend/jwt.php), [backend/auth_middleware.php](backend/auth_middleware.php), [backend/cors.php](backend/cors.php)
- Estilos: [frontend/assets/style.css](frontend/assets/style.css)

Índice
- Objetivo
- Arquitetura e funcionamento
- Tecnologias usadas (por que e como são usadas)
- Como executar localmente (XAMPP)
- Endpoints e fluxo de autenticação
- Banco de dados / schema
- Segurança e recomendações
- Estrutura de arquivos (links rápidos)

Objetivo
Esta aplicação permite que usuários se registrem, façam login (JWT) e gerenciem suas tarefas (criar, editar, marcar como concluída, deletar). É um projeto de exemplo com foco em autenticação, API REST e integração com um frontend reativo.

Arquitetura e funcionamento (visão geral)
- Frontend (Vue 3): interface do usuário — faz requisições HTTP para o backend em [backend/](backend/). Exemplos: [frontend/index.html](frontend/index.html) (login / registro) e [frontend/app.html](frontend/app.html) (lista e CRUD).
- Backend (PHP): expõe endpoints em [backend/*.php](backend/) que usam o banco MySQL. O backend usa JWT para autenticação.
  - A função de criação do token é [`jwt_create`](backend/jwt.php) e a verificação é [`jwt_verify`](backend/jwt.php).
  - Conexão com o banco via [`getPDO`](backend/db.php).
  - Proteção das rotas usa [`require_auth`](backend/auth_middleware.php), que extrai o token com [`getBearerToken`](backend/auth_middleware.php).
- Banco de dados: tabelas `users` e `tasks` definidas em [backend/dump.sql](backend/dump.sql).

Tecnologias usadas — por que e como
- PHP
  - Por que: linguagem simples e amplamente suportada por servidores como Apache (XAMPP). Facilita criar endpoints REST sem frameworks pesados.
  - Onde: todos os scripts em [backend/](backend/) — [backend/tasks.php](backend/tasks.php), [backend/login.php](backend/login.php), [backend/register.php](backend/register.php).
- MySQL
  - Por que: banco relacional leve e fácil de usar localmente (phpMyAdmin / XAMPP). Bom para esquemas simples (users, tasks).
  - Onde: esquema em [backend/dump.sql](backend/dump.sql). Conexão via [`getPDO`](backend/db.php).
- JWT (JSON Web Tokens)
  - Por que: permite autenticação stateless entre frontend e backend. O frontend guarda o token e envia no header Authorization.
  - Onde: criação e verificação em [backend/jwt.php](backend/jwt.php). Configuração de segredo e tempo de expiração em [backend/config.php](backend/config.php).
- Vue.js (v3)
  - Por que: permite construir uma UI reativa e leve sem build step (usando build da CDN).
  - Onde: usado diretamente em [frontend/index.html](frontend/index.html) e [frontend/app.html](frontend/app.html) para gerenciar estado, chamadas fetch e modais.
- Bootstrap 5
  - Por que: layout responsivo e componentes prontos para um frontend bonito rapidamente.
  - Onde: incluído nas páginas do frontend para grid, botões e estilos.
- Font Awesome
  - Por que: ícones para melhorar usabilidade/visual.
- CSS customizado
  - Por que: aparência personalizada (background animado, cards, modal). Arquivo: [frontend/assets/style.css](frontend/assets/style.css).
- CORS helper
  - Por que: permite chamadas AJAX entre frontend e backend quando necessário (arquivo [backend/cors.php](backend/cors.php)). Em produção, restrinja a origem.

Como executar localmente (passo a passo com XAMPP)
1. **Baixe ou clone o repositório** e coloque a pasta do projeto dentro de `htdocs` do XAMPP.
   - Exemplo: `C:\xampp\htdocs\TaskManager` ou `C:\xampp\htdocs\task` ou qualquer outro nome
   - **Importante**: O nome da pasta não importa! O sistema detecta automaticamente o caminho correto.

2. **Inicie os serviços no XAMPP**:
   - Abra o painel do XAMPP e inicie:
   - Apache
   - MySQL

3. **Configure o banco de dados**:
   - Acesse phpMyAdmin: http://localhost/phpmyadmin
   - Importe o arquivo [backend/dump.sql](backend/dump.sql) para criar o schema e tabelas.
   - **Ou crie manualmente**: Crie um banco chamado `taskmanager` e importe o dump.sql

4. **Configure as credenciais do banco** (se necessário):
   - Edite [backend/config.php](backend/config.php) caso seu MySQL tenha usuário/senha diferentes
   - Ajuste: `DB_NAME`, `DB_USER`, `DB_PASS` conforme necessário
   - **Importante**: O `DB_HOST` deve permanecer como `127.0.0.1` (ou `localhost`), pois o PHP roda no mesmo servidor que o MySQL.

5. **(Recomendado) Altere a chave JWT**:
   - Edite [backend/config.php](backend/config.php)
   - Defina uma string forte em `JWT_SECRET` (não use a chave padrão em produção)

6. **Acesse a aplicação no navegador**:
   - Use o nome da pasta que você colocou em `htdocs`
   - Exemplo: Se colocou como `task`, acesse: `http://localhost/task/frontend/index.html`
   - Exemplo: Se colocou como `TaskManager`, acesse: `http://localhost/TaskManager/frontend/index.html`
   - **O sistema detecta automaticamente o caminho do backend**, não precisa configurar nada!

**Nota importante sobre URLs**:
- ✅ As URLs do backend são **detectadas automaticamente** pelo frontend
- ✅ Funciona com **qualquer nome de pasta** (task, TaskManager, meu-projeto, etc.)
- ✅ Funciona tanto com `localhost` quanto com IP (acesso remoto)
- ✅ Não precisa alterar nenhum código quando mudar o nome da pasta ou acessar de outro PC

Acesso remoto (de outro PC na mesma rede)
Para acessar a aplicação de outro computador na mesma rede local:

1. **Descubra o IP do servidor**:
   - No Windows: Abra o Prompt de Comando (CMD) e digite `ipconfig`
   - Procure pelo "IPv4 Address" da sua placa de rede (ex: `192.168.1.100`)
   - No Linux/Mac: use `ifconfig` ou `ip addr`

2. **Configure o Firewall do Windows** (se necessário):
   - Abra o "Firewall do Windows Defender" no Painel de Controle
   - Clique em "Configurações Avançadas"
   - Crie uma nova regra de entrada para a porta 80 (HTTP) permitindo conexões TCP
   - Ou desative temporariamente o firewall para teste (não recomendado em produção)

4. **Verificações importantes**:
   - ✅ Certifique-se de que o Apache está rodando no servidor
   - ✅ Certifique-se de que ambos os PCs estão na mesma rede
   - ✅ O MySQL não precisa aceitar conexões remotas (o PHP roda no servidor)
   - ✅ O `DB_HOST` em `config.php` deve ser `127.0.0.1` (conexão local no servidor)

**Troubleshooting - Problemas Comuns**

**Problema: "Fica na tela de login" ou "Erro de conexão com banco de dados"**

1. **Verifique se o Apache e MySQL estão rodando no XAMPP**
   - Abra o painel do XAMPP
   - Certifique-se de que Apache e MySQL estão com status "Running" (verde)

2. **Verifique se o banco de dados foi criado corretamente**
   - Acesse: http://localhost/phpmyadmin
   - Verifique se existe um banco chamado `taskmanager`
   - Se não existir, importe o arquivo `backend/dump.sql`

3. **Verifique as credenciais do banco em `backend/config.php`**
   - `DB_NAME` deve ser `taskmanager` (ou o nome que você criou)
   - `DB_USER` deve ser `root` (padrão do XAMPP)
   - `DB_PASS` deve estar vazio `''` (padrão do XAMPP) ou a senha que você configurou
   - `DB_HOST` deve ser `127.0.0.1` ou `localhost`

4. **Verifique se está acessando a URL correta**
   - Use exatamente o nome da pasta que está em `htdocs`
   - Exemplo: Se a pasta é `task`, acesse `http://localhost/task/frontend/index.html`
   - Exemplo: Se a pasta é `TaskManager`, acesse `http://localhost/TaskManager/frontend/index.html`

5. **Teste se o backend está respondendo**
   - Tente acessar diretamente: `http://localhost/[SUA_PASTA]/backend/login.php`
   - Se aparecer um erro de JSON, está funcionando (só precisa enviar dados)
   - Se aparecer erro 404, verifique o caminho da pasta

6. **Verifique o console do navegador (F12)**
   - Abra as Ferramentas de Desenvolvedor (F12)
   - Vá na aba "Console" e veja se há erros JavaScript
   - Vá na aba "Network" e veja se as requisições ao backend estão falhando

**Troubleshooting de acesso remoto**:
- Se não conseguir acessar de outro PC, verifique se o firewall está bloqueando a porta 80
- Teste se o Apache responde localmente no servidor primeiro
- Certifique-se de que ambos os PCs estão na mesma rede
- Use o mesmo nome da pasta no servidor e na URL de acesso

Endpoints e fluxo de autenticação
- Registro
  - POST [backend/register.php](backend/register.php)
  - Corpo: JSON com first_name, last_name, birth_date, username, password
- Login
  - POST [backend/login.php](backend/login.php)
  - Corpo: JSON com username, password
  - Retorna: { token, user } — token JWT criado por [`jwt_create`](backend/jwt.php)
  - O frontend salva em localStorage: chave `tm_token` e `tm_user`
- API de tarefas
  - GET [backend/tasks.php](backend/tasks.php) — lista de tarefas do usuário (autenticado)
  - GET [backend/tasks.php?id=ID](backend/tasks.php?id=) — obter tarefa específica
  - POST [backend/tasks.php](backend/tasks.php) — cria tarefa (title obrigatório)
  - PUT [backend/tasks.php](backend/tasks.php) — atualiza tarefa (envia id no corpo JSON)
  - DELETE [backend/tasks.php?id=ID](backend/tasks.php?id=) — deleta tarefa
  - Todas estas rotas usam [`require_auth`](backend/auth_middleware.php) para validar o token (`Authorization: Bearer <token>`). A verificação do JWT é feita por [`jwt_verify`](backend/jwt.php).
- Fluxo no frontend
  - Em [frontend/index.html](frontend/index.html): usuário faz login -> token salvo -> redireciona para [frontend/app.html](frontend/app.html)
  - Em [frontend/app.html](frontend/app.html): todas as requisições usam header Authorization formado em javascript (`'Authorization':'Bearer '+this.token`).

Banco de dados / schema
- Estrutura básica definida em [backend/dump.sql](backend/dump.sql):
  - Tabela `users`: id, first_name, last_name, birth_date, username (único), password_hash, created_at
  - Tabela `tasks`: id, user_id (FK -> users.id), title, description, created_at, due_date, status ('open'|'done')
- Observação: o dump contém uma linha de exemplo de usuário; substitua o hash por um real ou registre via frontend.

Segurança e recomendações
- Alterar `JWT_SECRET` em [backend/config.php](backend/config.php) para uma chave forte.
- Em produção, restrinja CORS em [backend/cors.php](backend/cors.php) (não usar '*').
- Use HTTPS em produção.
- Armazenamento de senha: o backend usa `password_hash`/`password_verify` (boa prática).
- Tokens expiram conforme `JWT_EXPIRY` em [backend/config.php](backend/config.php).
- Não exponha `dump.sql` contendo hashes reais em repositórios públicos.

Estrutura de arquivos (links)
- Frontend:
  - [frontend/index.html](frontend/index.html)
  - [frontend/app.html](frontend/app.html)
  - [frontend/credits.html](frontend/credits.html)
  - [frontend/assets/style.css](frontend/assets/style.css)
- Backend:
  - [backend/login.php](backend/login.php)
  - [backend/register.php](backend/register.php)
  - [backend/tasks.php](backend/tasks.php)
  - [backend/auth_middleware.php](backend/auth_middleware.php)
  - [backend/jwt.php](backend/jwt.php)
  - [backend/db.php](backend/db.php)
  - [backend/config.php](backend/config.php)
  - [backend/cors.php](backend/cors.php)
  - [backend/dump.sql](backend/dump.sql)

Funções / símbolos importantes (links)
- Conexão DB: [`getPDO`](backend/db.php)
- JWT: [`jwt_create`](backend/jwt.php), [`jwt_verify`](backend/jwt.php)
- Middleware auth: [`require_auth`](backend/auth_middleware.php), [`getBearerToken`](backend/auth_middleware.php)
- Rotas principais: [`login.php`](backend/login.php), [`register.php`](backend/register.php), [`tasks.php`](backend/tasks.php)

Como contribuir / desenvolvimento
- Rodar o projeto localmente via XAMPP.
- Alterações no frontend podem ser feitas diretamente em [frontend/*.html] e [frontend/assets/style.css].
- Backend: scripts PHP em [backend/]. Teste endpoints com Postman ou via frontend.
- Para mudanças no DB, atualize [backend/dump.sql] e execute import no phpMyAdmin.


Notas finais
- Esta é uma base educativa e funcional para um gerenciador de tarefas com autenticação JWT e API REST. 