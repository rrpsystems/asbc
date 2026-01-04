# 🚀 Guia de Instalação e Configuração - ASBC RRP Systems

## Sistema de Billing e CDR - Laravel + PostgreSQL

Este guia contém instruções completas para instalação e configuração do sistema em servidores Debian 12.

---

## 📋 Requisitos do Sistema

- **Sistema Operacional**: Debian 12 (Bookworm)
- **PHP**: 8.4+
- **Banco de Dados**: PostgreSQL 17
- **Servidor Web**: Apache 2.4+
- **Memória RAM**: Mínimo 2GB (Recomendado 4GB+)
- **Espaço em Disco**: Mínimo 10GB

---

## 🔧 1. Preparação do Sistema

### 1.1 Atualizar o Sistema

```bash
sudo apt update && sudo apt upgrade -y
```

### 1.2 Instalar Dependências Básicas

```bash
sudo apt install -y curl wget git unzip software-properties-common \
    apt-transport-https ca-certificates gnupg lsb-release
```

---

## 🐘 2. Instalação do PHP 8.4

### 2.1 Adicionar Repositório Sury

```bash
# Adicionar chave GPG
sudo curl -sSLo /usr/share/keyrings/deb.sury.org-php.gpg \
    https://packages.sury.org/php/apt.gpg

# Adicionar repositório
echo "deb [signed-by=/usr/share/keyrings/deb.sury.org-php.gpg] \
https://packages.sury.org/php/ $(lsb_release -sc) main" | \
sudo tee /etc/apt/sources.list.d/php.list

sudo apt update
```

### 2.2 Instalar PHP e Extensões

```bash
sudo apt install -y php8.4 php8.4-cli php8.4-common php8.4-pgsql \
    php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip php8.4-bcmath \
    php8.4-gd php8.4-intl php8.4-redis php8.4-opcache php8.4-soap \
    libapache2-mod-php8.4
```

### 2.3 Verificar Instalação

```bash
php -v
# Deve mostrar: PHP 8.4.x
```

---

## 🐘 3. Instalação do PostgreSQL 17

### 3.1 Adicionar Repositório Oficial PostgreSQL

```bash
# Importar chave GPG
sudo curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc | \
    sudo gpg --dearmor -o /usr/share/keyrings/postgresql-keyring.gpg

# Adicionar repositório
echo "deb [signed-by=/usr/share/keyrings/postgresql-keyring.gpg] \
http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" | \
sudo tee /etc/apt/sources.list.d/pgdg.list

sudo apt update
```

### 3.2 Instalar PostgreSQL 17

```bash
sudo apt install -y postgresql-17 postgresql-client-17 postgresql-contrib-17
```

### 3.3 Verificar Instalação

```bash
sudo systemctl status postgresql
psql --version
# Deve mostrar: psql (PostgreSQL) 17.x
```

### 3.4 Configurar Banco de Dados

```bash
# Acessar PostgreSQL como usuário postgres
sudo -u postgres psql

# Executar dentro do psql:
CREATE DATABASE asbc_billing;
CREATE USER asbc_user WITH PASSWORD 'sua_senha_segura_aqui';
GRANT ALL PRIVILEGES ON DATABASE asbc_billing TO asbc_user;
ALTER DATABASE asbc_billing OWNER TO asbc_user;

# Conceder privilégios no schema public (PostgreSQL 15+)
\c asbc_billing
GRANT ALL ON SCHEMA public TO asbc_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO asbc_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO asbc_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO asbc_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO asbc_user;

# Sair
\q
```

### 3.5 Configurar Acesso Remoto (Opcional)

```bash
# Editar postgresql.conf
sudo vim /etc/postgresql/17/main/postgresql.conf

# Localizar e alterar:
listen_addresses = 'localhost'  # ou '*' para todas as interfaces

# Editar pg_hba.conf
sudo vim /etc/postgresql/17/main/pg_hba.conf

# Adicionar linha (ajuste o IP conforme necessário):
host    all             all             192.168.1.0/24          scram-sha-256

# Reiniciar PostgreSQL
sudo systemctl restart postgresql
```

---

## 🌐 4. Instalação e Configuração do Apache

### 4.1 Instalar Apache

```bash
sudo apt install -y apache2
```

### 4.2 Habilitar Módulos Necessários

```bash
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod ssl
sudo a2enmod php8.4
sudo systemctl restart apache2
```

### 4.3 Criar VirtualHost

```bash
sudo vim /etc/apache2/sites-available/asbc.conf
```

Adicionar a seguinte configuração:

```apache
<VirtualHost *:80>
    ServerName seu-dominio.com
    ServerAlias www.seu-dominio.com
    ServerAdmin admin@seu-dominio.com

    DocumentRoot /var/www/asbc/public

    <Directory /var/www/asbc>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <Directory /var/www/asbc/public>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    # Logs
    ErrorLog ${APACHE_LOG_DIR}/asbc-error.log
    CustomLog ${APACHE_LOG_DIR}/asbc-access.log combined

    # Segurança
    <FilesMatch "^\.">
        Require all denied
    </FilesMatch>

    <Files ~ "^\.ht">
        Require all denied
    </Files>
</VirtualHost>
```

### 4.4 Ativar Site e Desativar Default

```bash
sudo a2ensite asbc.conf
sudo a2dissite 000-default.conf
sudo apache2ctl configtest
sudo systemctl reload apache2
```

---

## 📦 5. Instalação do Composer

```bash
# Baixar instalador
curl -sS https://getcomposer.org/installer -o composer-setup.php

# Verificar hash (opcional mas recomendado)
HASH="$(curl -sS https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { \
    echo 'Installer verified'; } else { \
    echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

# Instalar globalmente
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Remover instalador
rm composer-setup.php

# Verificar instalação
composer --version
```

---

## 📦 6. Instalação do Node.js e NPM

```bash
# Instalar Node.js 20 LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Verificar instalação
node -v
npm -v
```

---

## 🔧 7. Instalação do Supervisor

```bash
sudo apt install -y supervisor
sudo systemctl enable supervisor
sudo systemctl start supervisor
```

---

## 📂 8. Preparação do Projeto

### 8.1 Criar Diretório e Clonar/Copiar Projeto

```bash
# Criar diretório
sudo mkdir -p /var/www/asbc

# Se usar Git:
# sudo git clone https://seu-repositorio.git /var/www/asbc

# Ou copiar arquivos:
# sudo cp -r /caminho/origem/* /var/www/asbc/

# Navegar para o diretório
cd /var/www/asbc
```

### 8.2 Configurar Permissões

```bash
# Definir proprietário
sudo chown -R www-data:www-data /var/www/asbc

# Definir permissões base
sudo find /var/www/asbc -type f -exec chmod 644 {} \;
sudo find /var/www/asbc -type d -exec chmod 755 {} \;

# Permissões especiais para diretórios de escrita
sudo chmod -R 775 /var/www/asbc/storage
sudo chmod -R 775 /var/www/asbc/bootstrap/cache
```

### 8.3 Instalar Dependências PHP

```bash
cd /var/www/asbc
sudo -u www-data composer install --optimize-autoloader --no-dev
```

### 8.4 Instalar Dependências Node.js

```bash
sudo -u www-data npm install
```

### 8.5 Compilar Assets

```bash
sudo -u www-data npm run build
```

---

## ⚙️ 9. Configuração do Laravel

### 9.1 Criar e Configurar .env

```bash
# Copiar arquivo de exemplo
sudo cp .env.example .env

# Editar configurações
sudo vim .env
```

Configurar as seguintes variáveis:

```env
APP_NAME="ASBC RRP Systems"
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=America/Sao_Paulo
APP_URL=http://seu-dominio.com

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

LOG_CHANNEL=daily
LOG_LEVEL=warning

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=asbc_billing
DB_USERNAME=asbc_user
DB_PASSWORD=sua_senha_segura_aqui

SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database

CACHE_STORE=database
```

### 9.2 Gerar Chave da Aplicação

```bash
sudo -u www-data php artisan key:generate
```

### 9.3 Executar Migrações

```bash
sudo -u www-data php artisan migrate --force
```

### 9.4 Criar Tabela de Sessions

```bash
sudo -u www-data php artisan session:table
sudo -u www-data php artisan migrate --force
```

### 9.5 Otimizar Cache

```bash
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache
```

---

## ⏰ 10. Configuração do Cron (Laravel Scheduler)

### 10.1 Criar Arquivo Cron

```bash
sudo vim /etc/cron.d/laravel-scheduler
```

Adicionar:

```cron
# Laravel Scheduler - ASBC RRP Systems
SHELL=/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

* * * * * www-data cd /var/www/asbc && php artisan schedule:run >> /dev/null 2>&1
```

### 10.2 Verificar Permissões

```bash
sudo chmod 644 /etc/cron.d/laravel-scheduler
```

### 10.3 Testar Scheduler Manualmente

```bash
sudo -u www-data php artisan schedule:list
sudo -u www-data php artisan schedule:run
```

---

## 👷 11. Configuração do Supervisor (Queue Workers)

### 11.1 Criar Arquivo de Configuração

```bash
sudo vim /etc/supervisor/conf.d/asbc-worker.conf
```

Adicionar:

```ini
[program:asbc-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/asbc/artisan queue:work database --sleep=3 --tries=3 --max-time=3600 --timeout=300
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/asbc/storage/logs/worker.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=3600
startsecs=0
```

### 11.2 Atualizar Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start asbc-worker:*
```

### 11.3 Verificar Status

```bash
sudo supervisorctl status
```

---

## 🔧 12. Otimização do PHP

### 12.1 Configurar php.ini para Apache

```bash
sudo vim /etc/php/8.4/apache2/php.ini
```

Ajustar as seguintes configurações:

```ini
; Configurações Básicas
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
post_max_size = 64M
upload_max_filesize = 64M
date.timezone = America/Sao_Paulo

; Configurações de Sessão
session.gc_probability = 1
session.gc_divisor = 1000
session.gc_maxlifetime = 7200

; OPcache (Performance)
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.max_wasted_percentage=5
opcache.use_cwd=1
opcache.validate_timestamps=1
opcache.revalidate_freq=2
opcache.fast_shutdown=1

; Realpath Cache (Performance)
realpath_cache_size=4096K
realpath_cache_ttl=600

; Desabilitar funções perigosas
disable_functions = exec,passthru,shell_exec,system,proc_open,popen
```

### 12.2 Configurar php.ini para CLI

```bash
sudo vim /etc/php/8.4/cli/php.ini
```

Ajustar:

```ini
memory_limit = 1024M
max_execution_time = 0
date.timezone = America/Sao_Paulo
```

### 12.3 Reiniciar Apache

```bash
sudo systemctl restart apache2
```

---

## 🔥 13. Configuração do Firewalld

### 13.1 Instalar Firewalld

```bash
sudo apt install -y firewalld
sudo systemctl enable firewalld
sudo systemctl start firewalld
```

### 13.2 Configurar Regras Básicas

```bash
# Verificar zonas
sudo firewall-cmd --get-active-zones

# Permitir SSH
sudo firewall-cmd --permanent --add-service=ssh

# Permitir HTTP
sudo firewall-cmd --permanent --add-service=http

# Permitir HTTPS
sudo firewall-cmd --permanent --add-service=https

# Permitir PostgreSQL (se acesso remoto for necessário)
sudo firewall-cmd --permanent --add-service=postgresql

# Recarregar configurações
sudo firewall-cmd --reload
```

### 13.3 Verificar Regras

```bash
sudo firewall-cmd --list-all
```

### 13.4 Configurações Avançadas (Opcional)

```bash
# Bloquear IPs específicos
sudo firewall-cmd --permanent --add-rich-rule='rule family="ipv4" source address="192.168.1.100" reject'

# Permitir IP específico
sudo firewall-cmd --permanent --add-rich-rule='rule family="ipv4" source address="192.168.1.50" accept'

# Limitar taxa de conexões SSH (proteção contra brute force)
sudo firewall-cmd --permanent --add-rich-rule='rule service name="ssh" limit value="10/m" accept'

# Recarregar
sudo firewall-cmd --reload
```

---

## 📝 14. Configuração de Logs

### 14.1 Criar Configuração de Logrotate

```bash
sudo vim /etc/logrotate.d/asbc
```

Adicionar:

```
/var/www/asbc/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    dateext
    dateformat -%Y-%m-%d
    sharedscripts
    postrotate
        systemctl reload apache2 > /dev/null 2>&1 || true
    endscript
}
```

### 14.2 Testar Logrotate

```bash
sudo logrotate -d /etc/logrotate.d/asbc
sudo logrotate -f /etc/logrotate.d/asbc
```

---

## 🔒 15. SSL/TLS com Let's Encrypt (Certbot)

### 15.1 Instalar Certbot

```bash
sudo apt install -y certbot python3-certbot-apache
```

### 15.2 Obter Certificado

```bash
sudo certbot --apache -d seu-dominio.com -d www.seu-dominio.com
```

### 15.3 Renovação Automática

```bash
# Testar renovação
sudo certbot renew --dry-run

# Criar job de renovação automática (já configurado automaticamente)
sudo systemctl status certbot.timer
```

### 15.4 Configurar VirtualHost HTTPS

O Certbot cria automaticamente, mas você pode editar:

```bash
sudo vim /etc/apache2/sites-available/asbc-le-ssl.conf
```

---

## 🚀 16. Script de Deploy

### 16.1 Criar Script de Deploy

```bash
sudo vim /var/www/asbc/deploy.sh
```

Adicionar:

```bash
#!/bin/bash

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Iniciando deploy do ASBC RRP Systems...${NC}"

# Verificar se está no diretório correto
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Erro: arquivo artisan não encontrado. Execute no diretório raiz do projeto.${NC}"
    exit 1
fi

# Ativar modo de manutenção
echo -e "${YELLOW}📋 Ativando modo de manutenção...${NC}"
php artisan down || true

# Atualizar código (se usar Git)
if [ -d ".git" ]; then
    echo -e "${YELLOW}📥 Atualizando código do repositório...${NC}"
    git pull origin main
fi

# Instalar/atualizar dependências PHP
echo -e "${YELLOW}📦 Instalando dependências PHP...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# Instalar/atualizar dependências Node
echo -e "${YELLOW}📦 Instalando dependências Node.js...${NC}"
npm install --production

# Compilar assets
echo -e "${YELLOW}🔨 Compilando assets...${NC}"
npm run build

# Limpar caches
echo -e "${YELLOW}🧹 Limpando caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan event:clear

# Executar migrações
echo -e "${YELLOW}🗄️  Executando migrações...${NC}"
php artisan migrate --force

# Recriar caches otimizados
echo -e "${YELLOW}⚡ Recriando caches otimizados...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Reiniciar queue workers
echo -e "${YELLOW}♻️  Reiniciando queue workers...${NC}"
sudo supervisorctl restart asbc-worker:*

# Reiniciar Apache
echo -e "${YELLOW}🔄 Reiniciando Apache...${NC}"
sudo systemctl reload apache2

# Desativar modo de manutenção
echo -e "${YELLOW}✅ Desativando modo de manutenção...${NC}"
php artisan up

echo -e "${GREEN}✅ Deploy concluído com sucesso!${NC}"
```

### 16.2 Tornar Executável

```bash
sudo chmod +x /var/www/asbc/deploy.sh
sudo chown www-data:www-data /var/www/asbc/deploy.sh
```

### 16.3 Executar Deploy

```bash
cd /var/www/asbc
sudo -u www-data ./deploy.sh
```

---

## 🔍 17. Verificação e Testes

### 17.1 Verificar Serviços

```bash
# Status dos serviços
sudo systemctl status apache2
sudo systemctl status postgresql
sudo systemctl status supervisor

# Verificar portas abertas
sudo ss -tulpn | grep -E ':(80|443|5432)'
```

### 17.2 Testar Aplicação

```bash
# Verificar status das migrações
sudo -u www-data php artisan migrate:status

# Verificar rotas
sudo -u www-data php artisan route:list

# Verificar configuração
sudo -u www-data php artisan config:show

# Testar conexão com banco
sudo -u www-data php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

### 17.3 Verificar Queue Workers

```bash
# Status do supervisor
sudo supervisorctl status asbc-worker:*

# Logs do worker
tail -f /var/www/asbc/storage/logs/worker.log
```

### 17.4 Verificar Scheduler

```bash
# Listar tarefas agendadas
sudo -u www-data php artisan schedule:list

# Executar manualmente
sudo -u www-data php artisan schedule:run

# Verificar logs do cron
sudo grep CRON /var/log/syslog | tail -20
```

### 17.5 Verificar Logs da Aplicação

```bash
# Laravel logs
tail -f /var/www/asbc/storage/logs/laravel.log

# Apache logs
sudo tail -f /var/log/apache2/asbc-error.log
sudo tail -f /var/log/apache2/asbc-access.log

# PostgreSQL logs
sudo tail -f /var/log/postgresql/postgresql-17-main.log
```

---

## 🔧 18. Comandos Úteis de Manutenção

### 18.1 Limpar Cache

```bash
cd /var/www/asbc

# Limpar todos os caches
sudo -u www-data php artisan optimize:clear

# Ou individualmente:
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan view:clear
```

### 18.2 Recriar Cache Otimizado

```bash
sudo -u www-data php artisan optimize
```

### 18.3 Reiniciar Queue Workers

```bash
# Via supervisor
sudo supervisorctl restart asbc-worker:*

# Via artisan (envia sinal para workers pararem após job atual)
sudo -u www-data php artisan queue:restart
```

### 18.4 Modo Manutenção

```bash
# Ativar
sudo -u www-data php artisan down

# Ativar com mensagem customizada
sudo -u www-data php artisan down --message="Sistema em manutenção" --retry=60

# Desativar
sudo -u www-data php artisan up
```

### 18.5 Backup do Banco de Dados

```bash
# Criar backup
sudo -u postgres pg_dump asbc_billing > backup_$(date +%Y%m%d_%H%M%S).sql

# Ou com compressão
sudo -u postgres pg_dump asbc_billing | gzip > backup_$(date +%Y%m%d_%H%M%S).sql.gz

# Restaurar backup
sudo -u postgres psql asbc_billing < backup_20251201_120000.sql
```

---

## 🐛 19. Troubleshooting (Resolução de Problemas)

### 19.1 Erro 500 - Internal Server Error

```bash
# Verificar logs
sudo tail -100 /var/log/apache2/asbc-error.log
sudo tail -100 /var/www/asbc/storage/logs/laravel.log

# Verificar permissões
sudo chown -R www-data:www-data /var/www/asbc/storage
sudo chmod -R 775 /var/www/asbc/storage

# Limpar cache
sudo -u www-data php artisan optimize:clear
```

### 19.2 Erro de Conexão com Banco

```bash
# Verificar se PostgreSQL está rodando
sudo systemctl status postgresql

# Testar conexão
sudo -u postgres psql -c "SELECT version();"

# Verificar .env
cat /var/www/asbc/.env | grep DB_

# Testar conexão via artisan
sudo -u www-data php artisan tinker
>>> DB::connection()->getPdo();
```

### 19.3 Queue Workers Não Processam Jobs

```bash
# Verificar status
sudo supervisorctl status

# Ver logs
tail -f /var/www/asbc/storage/logs/worker.log

# Reiniciar workers
sudo supervisorctl restart asbc-worker:*

# Processar job manualmente para debug
sudo -u www-data php artisan queue:work --once --verbose
```

### 19.4 Scheduler Não Executa

```bash
# Verificar se cron está rodando
sudo systemctl status cron

# Verificar arquivo cron
cat /etc/cron.d/laravel-scheduler

# Verificar logs do cron
sudo grep CRON /var/log/syslog | tail -50

# Executar manualmente para debug
sudo -u www-data php artisan schedule:run -v
```

### 19.5 Permissões Incorretas

```bash
# Corrigir proprietário
sudo chown -R www-data:www-data /var/www/asbc

# Corrigir permissões
sudo find /var/www/asbc -type f -exec chmod 644 {} \;
sudo find /var/www/asbc -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/asbc/storage
sudo chmod -R 775 /var/www/asbc/bootstrap/cache
```

---

## 📊 20. Monitoramento

### 20.1 Monitorar Recursos do Sistema

```bash
# CPU e Memória
htop

# Espaço em disco
df -h

# Uso de disco por diretório
du -sh /var/www/asbc/*
```

### 20.2 Monitorar PostgreSQL

```bash
# Conexões ativas
sudo -u postgres psql -c "SELECT count(*) FROM pg_stat_activity;"

# Ver queries em execução
sudo -u postgres psql -c "SELECT pid, age(clock_timestamp(), query_start), usename, query 
FROM pg_stat_activity 
WHERE state != 'idle' AND query NOT ILIKE '%pg_stat_activity%' 
ORDER BY query_start desc;"

# Tamanho do banco
sudo -u postgres psql -c "SELECT pg_size_pretty(pg_database_size('asbc_billing'));"
```

### 20.3 Monitorar Apache

```bash
# Status do Apache
sudo apache2ctl status

# Conexões ativas
sudo ss -tan | grep :80 | wc -l

# Habilitar mod_status (para métricas detalhadas)
sudo a2enmod status
# Depois acessar: http://seu-dominio.com/server-status
```

---

## 🔐 21. Hardening de Segurança

### 21.1 Desabilitar Listagem de Diretórios

Já configurado no VirtualHost com `Options -Indexes`

### 21.2 Proteger Arquivos Sensíveis

```bash
# Criar arquivo .htaccess na raiz (se necessário)
sudo vim /var/www/asbc/.htaccess
```

Adicionar:

```apache
<FilesMatch "^\.env">
    Require all denied
</FilesMatch>
```

### 21.3 Configurar Headers de Segurança

Editar VirtualHost:

```bash
sudo vim /etc/apache2/sites-available/asbc.conf
```

Adicionar dentro do `<VirtualHost>`:

```apache
# Security Headers
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Content-Type-Options "nosniff"
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"

# HSTS (apenas se usar HTTPS)
# Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
```

### 21.4 Fail2Ban (Proteção contra Brute Force)

```bash
# Instalar Fail2Ban
sudo apt install -y fail2ban

# Criar configuração customizada
sudo vim /etc/fail2ban/jail.local
```

Adicionar:

```ini
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[sshd]
enabled = true
port = ssh
logpath = /var/log/auth.log

[apache-auth]
enabled = true
port = http,https
logpath = /var/log/apache2/*error.log
```

Reiniciar:

```bash
sudo systemctl restart fail2ban
sudo fail2ban-client status
```

---

## 📚 22. Recursos Adicionais

### 22.1 Documentação

- [Laravel Documentation](https://laravel.com/docs)
- [PostgreSQL Documentation](https://www.postgresql.org/docs/)
- [Apache Documentation](https://httpd.apache.org/docs/)

### 22.2 Comandos Artisan Úteis

```bash
# Listar todos os comandos
php artisan list

# Help de um comando específico
php artisan help migrate

# Criar controller
php artisan make:controller NomeController

# Criar model com migration
php artisan make:model NomeModel -m

# Criar job
php artisan make:job NomeJob
```

---

## 📧 23. Suporte e Contato

Para suporte técnico ou dúvidas sobre o sistema:

- **Email**: suporte@asbc.com.br
- **Documentação**: https://docs.asbc.com.br
- **Issues**: https://github.com/seu-repositorio/issues

---

## 📝 24. Changelog

### Versão 1.0.0 (2025-12-01)
- Instalação inicial do sistema
- Configuração de servidor Debian 12
- PHP 8.4 + PostgreSQL 17
- Apache + Supervisor + Firewalld

---

## 📄 Licença

Este projeto é proprietário da RRP Systems.

---

**Desenvolvido com ❤️ por RRP Systems**
