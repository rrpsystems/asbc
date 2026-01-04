# Instalação e Configuração do Kamailio + RTPEngine

Guia completo de instalação e configuração do Kamailio 6.0 com RTPEngine para integração com o sistema ASBC.

## 📋 Índice

- [Requisitos do Sistema](#requisitos-do-sistema)
- [Preparação do Ambiente](#preparação-do-ambiente)
- [Instalação do PostgreSQL 17](#instalação-do-postgresql-17)
- [Instalação do Kamailio 6](#instalação-do-kamailio-6)
- [Instalação do RTPEngine](#instalação-do-rtpengine)
- [Configuração do Kamailio](#configuração-do-kamailio)
- [Arquivos de Configuração](#arquivos-de-configuração)
- [Verificação e Testes](#verificação-e-testes)
- [Troubleshooting](#troubleshooting)

## Requisitos do Sistema

### Hardware Recomendado
- **CPU**: 2+ cores (4+ recomendado para produção)
- **RAM**: 4GB mínimo (8GB+ recomendado)
- **Disco**: 20GB+ SSD
- **Rede**: Interface de rede com suporte a jumbo frames (MTU 9000)

### Software
- **SO**: Debian 12 (Bookworm) - 64 bits
- **Kernel**: 5.10+ (para suporte completo ao RTPEngine)

### Portas Necessárias

| Porta | Protocolo | Descrição |
|-------|-----------|-----------|
| 22 | TCP | SSH |
| 5060 | UDP/TCP | SIP (Entrada de operadoras) |
| 5080 | UDP/TCP | SIP (Saída para operadoras) |
| 5090 | UDP/TCP | SIP (Alternativo) |
| 10000-30000 | UDP | RTP/RTCP (Mídia de voz) |

## Preparação do Ambiente

### 1. Atualização do Sistema

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y vim htop iftop net-tools iproute2 lsb-release curl wget gnupg2 \
  build-essential git unzip tcpdump firewalld rsyslog chrony sngrep
```

### 2. Otimizações de Sistema

#### Desabilitar CPU Scaling
```bash
sudo apt install cpufrequtils -y
echo 'GOVERNOR="performance"' | sudo tee /etc/default/cpufrequtils
sudo systemctl enable cpufrequtils
sudo systemctl start cpufrequtils

# Verificar
cpufreq-info | grep "current policy"
```

#### Ajustes de Rede para VoIP
```bash
sudo vim /etc/sysctl.d/99-voip-tuning.conf
```

Adicionar:
```conf
# Buffer máximo por socket
net.core.rmem_max = 26214400
net.core.wmem_max = 26214400

# Número de pacotes na fila do driver de rede
net.core.netdev_max_backlog = 5000

# Buffers UDP (min, pressure, max)
net.ipv4.udp_mem = 65536 131072 262144
net.ipv4.udp_rmem_min = 16384
net.ipv4.udp_wmem_min = 16384

# TCP congestion control
net.ipv4.tcp_congestion_control = bbr

# Range de portas locais (RTP)
net.ipv4.ip_local_port_range = 10000 65000

# Desativar Reverse Path Filtering (recomendado para SBC)
net.ipv4.conf.all.rp_filter = 0
net.ipv4.conf.default.rp_filter = 0
```

Aplicar:
```bash
sudo sysctl --system
```

#### Ajuste de Limites de Arquivos
```bash
sudo vim /etc/security/limits.conf
```

Adicionar:
```conf
*   soft  nofile  65535
*   hard  nofile  65535
*   soft  nproc   65535
*   hard  nproc   65535
```

```bash
sudo vim /etc/systemd/system.conf
```

Adicionar:
```conf
DefaultLimitNOFILE=65535
DefaultLimitNPROC=65535
```

```bash
sudo vim /etc/systemd/user.conf
```

Adicionar:
```conf
DefaultLimitNOFILE=65535
DefaultLimitNPROC=65535
```

Aplicar:
```bash
sudo systemctl daemon-reexec
sudo systemctl daemon-reload
```

### 3. Configuração do Firewall

```bash
# Definir zona padrão
sudo firewall-cmd --set-default-zone=public

# Liberar portas SIP
sudo firewall-cmd --zone=public --add-port=22/tcp --permanent
sudo firewall-cmd --zone=public --add-port=5060/udp --permanent
sudo firewall-cmd --zone=public --add-port=5060/tcp --permanent
sudo firewall-cmd --zone=public --add-port=5061/tcp --permanent
sudo firewall-cmd --zone=public --add-port=5080/udp --permanent
sudo firewall-cmd --zone=public --add-port=5080/tcp --permanent
sudo firewall-cmd --zone=public --add-port=5081/tcp --permanent
sudo firewall-cmd --zone=public --add-port=5090/udp --permanent
sudo firewall-cmd --zone=public --add-port=5090/tcp --permanent

# Liberar range RTP
sudo firewall-cmd --zone=public --add-port=10000-30000/udp --permanent

# Aplicar mudanças
sudo firewall-cmd --reload

# Integração com RTPEngine e Kamailio
sudo firewall-cmd --zone=trusted --add-interface=lo --permanent

# Desativar ALG (Application Layer Gateway)
sudo sysctl -w net.netfilter.nf_conntrack_helper=0
sudo sysctl -w net.netfilter.nf_conntrack_sip_enable=0
echo "net.netfilter.nf_conntrack_helper=0" | sudo tee -a /etc/sysctl.conf
echo "net.netfilter.nf_conntrack_sip_enable=0" | sudo tee -a /etc/sysctl.conf
sudo sysctl -p

# Habilitar firewall
sudo systemctl enable firewalld
sudo systemctl start firewalld
```

### 4. Sincronização de Tempo

```bash
sudo vim /etc/chrony/chrony.conf
```

Adicionar:
```conf
server pool.ntp.org iburst
```

```bash
sudo systemctl restart chronyd
chronyc tracking
```

## Instalação do PostgreSQL 17

```bash
# Importar chave de assinatura
sudo apt install curl ca-certificates
sudo install -d /usr/share/postgresql-common/pgdg
sudo curl -o /usr/share/postgresql-common/pgdg/apt.postgresql.org.asc --fail \
  https://www.postgresql.org/media/keys/ACCC4CF8.asc

# Adicionar repositório
. /etc/os-release
sudo sh -c "echo 'deb [signed-by=/usr/share/postgresql-common/pgdg/apt.postgresql.org.asc] \
  https://apt.postgresql.org/pub/repos/apt $VERSION_CODENAME-pgdg main' > \
  /etc/apt/sources.list.d/pgdg.list"

# Atualizar e instalar
sudo apt update
sudo apt -y install postgresql-17 postgresql-client-17 libpq-dev \
  postgresql-server-dev-17 unixodbc unixodbc-dev odbc-postgresql libtool libltdl-dev

# Iniciar serviço
sudo pg_createcluster 17 main --start
sudo systemctl enable postgresql@17-main
sudo systemctl start postgresql@17-main
```

### Configurar Banco de Dados

```bash
# Criar banco e usuário
sudo runuser -l postgres -c "psql -c \"CREATE DATABASE asbc;\""
sudo runuser -l postgres -c "psql -c \"CREATE USER asbc_user WITH ENCRYPTED PASSWORD 'SUA_SENHA_AQUI';\""
sudo runuser -l postgres -c "psql -c \"GRANT ALL PRIVILEGES ON DATABASE asbc TO asbc_user;\""

# Backup da configuração
sudo cp /etc/postgresql/17/main/pg_hba.conf /etc/postgresql/17/main/pg_hba.conf.bak

# Configurar autenticação
sudo sed -i "s|^local\s\+all\s\+all\s\+.*|local   all             all                                     md5|" \
  /etc/postgresql/17/main/pg_hba.conf
sudo sed -i "s|^host\s\+all\s\+all\s\+127\.0\.0\.1/32\s\+.*|host    all             all             127.0.0.1/32            md5|" \
  /etc/postgresql/17/main/pg_hba.conf
sudo sed -i "s|^host\s\+all\s\+all\s\+::1/128\s\+.*|host    all             all             ::1/128                 md5|" \
  /etc/postgresql/17/main/pg_hba.conf

# Reiniciar PostgreSQL
sudo systemctl restart postgresql@17-main

# Configurar permissões
sudo -u postgres psql << EOF
GRANT ALL PRIVILEGES ON SCHEMA public TO asbc_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO asbc_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO asbc_user;

\c asbc

ALTER ROLE asbc_user SET search_path = public;
GRANT CREATE ON SCHEMA public TO asbc_user;
GRANT USAGE ON SCHEMA public TO asbc_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO asbc_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO asbc_user;
EOF
```

## Instalação do Kamailio 6

```bash
# Atualizar sistema
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl gnupg lsb-release ca-certificates

# Adicionar repositório oficial do Kamailio 6.0
sudo mkdir -p /usr/share/keyrings
curl -fsSL https://deb.kamailio.org/kamailiodebkey.gpg | \
  sudo gpg --dearmor -o /usr/share/keyrings/kamailio-archive-keyring.gpg

echo "deb [signed-by=/usr/share/keyrings/kamailio-archive-keyring.gpg] \
  http://deb.kamailio.org/kamailio60 bookworm main" | \
  sudo tee /etc/apt/sources.list.d/kamailio.list

echo "deb-src [signed-by=/usr/share/keyrings/kamailio-archive-keyring.gpg] \
  http://deb.kamailio.org/kamailio60 bookworm main" | \
  sudo tee -a /etc/apt/sources.list.d/kamailio.list

# Atualizar lista de pacotes
sudo apt update

# Instalar Kamailio 6 e módulos
sudo apt install -y \
  kamailio \
  kamailio-postgres-modules \
  kamailio-extra-modules \
  kamailio-utils-modules \
  kamailio-tls-modules \
  kamailio-presence-modules \
  kamcli

# Configurar início automático
sudo sed -i 's/^#RUN_KAMAILIO=.*/RUN_KAMAILIO=yes/' /etc/default/kamailio
sudo sed -i 's/^#USER=.*/USER=kamailio/' /etc/default/kamailio
sudo sed -i 's/^#GROUP=.*/GROUP=kamailio/' /etc/default/kamailio

# Habilitar e iniciar
sudo systemctl enable kamailio
sudo systemctl start kamailio
sudo systemctl status kamailio
```

## Instalação do RTPEngine

### Dependências

```bash
sudo apt update && sudo apt full-upgrade -y
sudo apt install -y \
  git build-essential debhelper devscripts \
  default-libmysqlclient-dev libglib2.0-dev libcurl4-openssl-dev \
  libpcap-dev libxtables-dev libip6tc-dev libhiredis-dev \
  libpcre3-dev libssl-dev libxmlrpc-core-c3-dev libsystemd-dev gperf \
  ffmpeg libavcodec-dev libavutil-dev libavformat-dev libavfilter-dev \
  libopus-dev libspandsp-dev libbcg729-dev libwebsockets-dev \
  libjson-glib-dev libevent-dev libmnl-dev libnftnl-dev libncurses5-dev \
  libjwt-dev libglib2.0-dev libpcre2-dev libhiredis-dev libxml2-dev \
  libiptc-dev libxtables-dev linux-headers-$(uname -r)
```

### Compilação

```bash
cd /usr/src
sudo git clone https://github.com/sipwise/rtpengine.git
cd rtpengine

# Compilar com suporte a transcoding (G.729, G.711, G.722)
sudo make clean
sudo make mrproper
sudo make DEB_BUILD_OPTIONS=transcoding
sudo make install
```

### Configuração do Usuário

```bash
sudo groupadd --system rtpengine
sudo useradd --system --gid rtpengine --home /var/lib/rtpengine --shell /bin/false rtpengine
sudo mkdir -p /var/run/rtpengine /run/rtpengine /etc/rtpengine
sudo chown rtpengine:rtpengine /var/run/rtpengine /run/rtpengine /etc/rtpengine
```

### Arquivo de Configuração

```bash
sudo vim /etc/rtpengine/rtpengine.conf
```

Consulte [rtpengine.conf](configs/rtpengine.conf) para configuração completa.

### Service Systemd

```bash
sudo vim /etc/systemd/system/rtpengine.service
```

Adicionar:
```ini
[Unit]
Description=RTPEngine User-Space Daemon
After=network.target

[Service]
Type=simple
User=rtpengine
Group=rtpengine
PIDFile=/run/rtpengine/rtpengine.pid
ExecStart=/usr/bin/rtpengine --config-file=/etc/rtpengine/rtpengine.conf
ExecReload=/bin/kill -HUP $MAINPID
Restart=on-failure

# Limites para produção
LimitNOFILE=65535
LimitNPROC=65535

# Scheduler e prioridade
CPUSchedulingPolicy=rr
CPUSchedulingPriority=80
IOSchedulingPriority=0

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl daemon-reload
sudo systemctl enable rtpengine
sudo systemctl start rtpengine
sudo systemctl status rtpengine
```

## Configuração do Kamailio

### Estrutura de Arquivos

Os arquivos de configuração do Kamailio estão localizados em `/etc/kamailio/`:

```
/etc/kamailio/
├── kamailio.cfg          # Configuração principal
├── base-routes.cfg       # Rotas básicas e handlers
├── calls-in.cfg          # Processamento de chamadas de entrada
├── calls-out.cfg         # Processamento de chamadas de saída
└── calls-audio.cfg       # Gerenciamento de áudio e bloqueios
```

Consulte a pasta [configs/](configs/) para os arquivos de configuração completos.

### Variáveis Importantes

Antes de usar os arquivos de configuração, ajuste as seguintes variáveis:

#### kamailio.cfg
- `PUBLIC_IP`: Seu IP público (linha 34)
- `listen`: IPs e portas de escuta (linhas 49-56)
- String de conexão PostgreSQL (linha 130)

#### rtpengine.conf
- `interface`: Nome da sua interface de rede
- IP público para anúncio no SDP

## Verificação e Testes

### Verificar Serviços
```bash
systemctl status kamailio
systemctl status rtpengine
systemctl status postgresql@17-main
```

### Verificar Portas
```bash
ss -uapn | grep 5060
ss -uapn | grep 10000
sudo netstat -lnp | grep rtpengine
```

### Testar RTPEngine
```bash
journalctl -u rtpengine | grep codec
# Deve mostrar: Loaded transcoder module with codecs: G.711,G.722,G.729
```

### Captura de Pacotes
```bash
sudo tcpdump -n udp port 5060
sudo tcpdump -n udp port 10000
```

### Health Check do Kamailio
```bash
curl -X OPTIONS http://SEU_IP:5060/health
```

## Troubleshooting

### Kamailio não inicia
```bash
# Verificar logs
journalctl -u kamailio -n 100 --no-pager

# Testar configuração
kamailio -c -f /etc/kamailio/kamailio.conf
```

### RTPEngine sem áudio
```bash
# Verificar interfaces
ip addr show

# Verificar firewall
sudo firewall-cmd --list-all

# Verificar RTPEngine
sudo rtpengine --version
```

### Problemas com PostgreSQL
```bash
# Verificar conexão
psql -h 127.0.0.1 -U asbc_user -d asbc

# Verificar logs
sudo journalctl -u postgresql@17-main -n 100
```

### Performance Issues
```bash
# Verificar uso de CPU
htop

# Verificar conexões
kamctl stats | grep dialog

# Verificar memória compartilhada
kamctl stats | grep shm
```

## Próximos Passos

Após a instalação e configuração do Kamailio:

1. Configure o sistema ASBC seguindo o [README principal](../../README.md)
2. Configure os CDRs no banco de dados PostgreSQL
3. Integre com o dashboard Laravel do ASBC
4. Configure monitoramento e alertas

## Suporte

Para problemas específicos do ASBC, consulte:
- [Documentação Principal](../../README.md)
- [Issues no GitHub](https://github.com/rrpsystems/asbc/issues)
