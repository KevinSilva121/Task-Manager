Dependências do Projeto

Este documento lista todas as dependências do projeto e como verificar se há atualizações disponíveis.

Dependências Frontend (CDN)

1. Bootstrap 5
- Versão atual: `5.3.0`
- CDN: `https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css`
- Usado em: `index.html`, `app.html`, `credits.html`
- Verificar atualizações: 
  - Site oficial: https://getbootstrap.com/
  - NPM: https://www.npmjs.com/package/bootstrap
  - Última versão: https://cdn.jsdelivr.net/npm/bootstrap@latest/dist/css/bootstrap.min.css

2. Font Awesome 6
- Versão atual: `6.4.0`
- CDN: `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css`
- Usado em: `index.html`, `app.html`, `credits.html`
- Verificar atualizações: 
  - Site oficial: https://fontawesome.com/
  - CDN: https://cdnjs.com/libraries/font-awesome
  - Última versão: https://cdnjs.cloudflare.com/ajax/libs/font-awesome/latest/css/all.min.css

3. Vue.js 3
- Versão atual: `3` (última versão 3.x)
- CDN: `https://unpkg.com/vue@3/dist/vue.global.prod.js`
- Usado em: `index.html`, `app.html`
- Verificar atualizações: 
  - Site oficial: https://vuejs.org/
  - NPM: https://www.npmjs.com/package/vue
  - Última versão 3: https://unpkg.com/vue@3/dist/vue.global.prod.js
  - Última versão geral: https://unpkg.com/vue@latest/dist/vue.global.prod.js

Dependências Backend

1. PHP
- Versão: Depende do XAMPP instalado
- Requisito mínimo: PHP 7.4+ (recomendado PHP 8.0+)
- Verificar versão: Execute `php -v` no terminal ou veja no painel do XAMPP
- Verificar atualizações: https://www.php.net/downloads.php

2. MySQL
- Versão: Depende do XAMPP instalado
- Requisito mínimo: MySQL 5.7+ ou MariaDB 10.2+
- Verificar versão: Execute `mysql --version` no terminal ou veja no phpMyAdmin
- Verificar atualizações: https://www.mysql.com/downloads/ ou https://mariadb.org/download/

3. Apache
- Versão: Depende do XAMPP instalado
- Requisito mínimo: Apache 2.4+
- Verificar versão: Veja no painel do XAMPP ou acesse http://localhost/
- Verificar atualizações: https://httpd.apache.org/download.cgi

Como Verificar Atualizações

Método 1: Verificação Manual

1. Bootstrap: Acesse https://getbootstrap.com/docs/5.3/getting-started/introduction/ e verifique se há uma versão mais recente que 5.3.0
2. Font Awesome: Acesse https://fontawesome.com/docs e verifique a versão mais recente
3. Vue.js: Acesse https://vuejs.org/ e verifique se há atualizações na versão 3

Método 2: Usar o Script de Verificação

Execute o script `check-dependencies.html` no navegador para verificar automaticamente as versões disponíveis.

Método 3: Verificar via NPM (se tiver Node.js instalado)

```bash
npm outdated bootstrap
npm outdated @fortawesome/fontawesome-free
npm outdated vue
```

Atualizando Dependências

Importante: Antes de atualizar, teste bem a aplicação após a mudança, pois atualizações podem trazer mudanças que quebram compatibilidade.

Para atualizar Bootstrap:
1. Verifique a versão mais recente em https://getbootstrap.com/
2. Atualize a URL do CDN em `index.html`, `app.html` e `credits.html`
3. Exemplo: `@5.3.0` → `@5.3.2` (ou a versão mais recente)

Para atualizar Font Awesome:
1. Verifique a versão mais recente em https://cdnjs.com/libraries/font-awesome
2. Atualize a URL do CDN em `index.html`, `app.html` e `credits.html`
3. Exemplo: `6.4.0` → `6.5.0` (ou a versão mais recente)

Para atualizar Vue.js:
1. Verifique se há atualizações em https://vuejs.org/
2. Se houver uma nova versão 3.x, o `@3` já pegará automaticamente
3. Se quiser uma versão específica, use: `vue@3.4.0` (substitua pela versão desejada)

Versões Testadas e Funcionando

- Bootstrap 5.3.0
- Font Awesome 6.4.0
- Vue.js 3.x (testado com 3.3.x)
- PHP 7.4+ / 8.0+ / 8.1+ / 8.2+
- MySQL 5.7+ / 8.0+ / MariaDB 10.2+

Notas

- As dependências frontend são carregadas via CDN, então não precisam ser instaladas localmente
- As dependências backend (PHP, MySQL, Apache) vêm com o XAMPP
- Sempre teste após atualizar dependências para garantir que tudo continua funcionando
- Para produção, considere usar versões fixas (sem `@latest`) para evitar quebras inesperadas

