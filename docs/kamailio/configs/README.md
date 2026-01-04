# Arquivos de Configuração do Kamailio

Arquivos de configuração prontos para uso com o sistema ASBC.

## Estrutura de Arquivos

```
/etc/kamailio/
├── kamailio.cfg          # Configuração principal
├── base-routes.cfg       # Rotas básicas e handlers
├── calls-in.cfg          # Chamadas de entrada (operadora → cliente)
├── calls-out.cfg         # Chamadas de saída (cliente → operadora)
└── calls-audio.cfg       # Gerenciamento de áudio e bloqueios
```

## Arquivos Disponíveis

### rtpengine.conf
Configuração do RTPEngine com suporte a transcoding de codecs.

**Localização**: `/etc/rtpengine/rtpengine.conf`

**Variáveis para ajustar**:
- `interface`: Nome da interface de rede (ex: `enp0s5`, `eth0`)
- IP público: Substitua `1.2.3.4` pelo seu IP público real

### kamailio.cfg (não incluído)
Arquivo principal de configuração do Kamailio.

**Importante**: Este arquivo contém configurações sensíveis e específicas do servidor.

**Variáveis principais a configurar**:
```cfg
#!define PUBLIC_IP "SEU_IP_PUBLICO"

listen=udp:0.0.0.0:5060 advertise SEU_IP_PUBLICO:5060
listen=tcp:0.0.0.0:5060 advertise SEU_IP_PUBLICO:5060

# String de conexão PostgreSQL
modparam("sqlops", "sqlcon", "pc=>postgres://usuario:senha@localhost/banco")
```

### base-routes.cfg (não incluído)
Rotas básicas de processamento de chamadas:
- Request routing
- Dialog management
- CDR storage
- Codec extraction
- Channel control

### calls-in.cfg (não incluído)
Processamento de chamadas de entrada:
- Validação de DID
- Lookup de cliente
- Controle de canais
- Billing de entrada

### calls-out.cfg (não incluído)
Processamento de chamadas de saída:
- Normalização de números
- Lookup de tarifas
- Seleção de operadora
- Billing de saída

### calls-audio.cfg (não incluído)
Gerenciamento de áudio:
- Bloqueio de chamadas
- Mensagens de erro
- Controle de codec

## Como Usar

### 1. Copiar Arquivo de Exemplo

```bash
sudo cp rtpengine.conf /etc/rtpengine/
```

### 2. Ajustar Configurações

```bash
sudo vim /etc/rtpengine/rtpengine.conf
```

Ajuste:
- Nome da interface de rede
- IP público
- Portas RTP se necessário

### 3. Validar Sintaxe

```bash
# Para Kamailio
kamailio -c -f /etc/kamailio/kamailio.cfg

# Para RTPEngine
rtpengine --config-file=/etc/rtpengine/rtpengine.conf --config-section=rtpengine
```

### 4. Reiniciar Serviços

```bash
sudo systemctl restart rtpengine
sudo systemctl restart kamailio
```

## Variáveis de Ambiente

### Banco de Dados PostgreSQL

No arquivo `kamailio.cfg`, configure a conexão com o banco:

```cfg
modparam("sqlops", "sqlcon", "pc=>postgres://asbc_user:SUA_SENHA@localhost/asbc")
```

### IPs e Portas

**Portas SIP**:
- `5060`: Entrada de operadoras (UDP/TCP)
- `5080`: Saída para operadoras (UDP/TCP)
- `5090`: Porta alternativa (UDP/TCP)

**Portas RTP**:
- `10000-30000`: Range de portas para mídia

### RTPEngine

**Porta de controle**: `2223` (UDP localhost)

## Segurança

⚠️ **IMPORTANTE**:
- Nunca commite arquivos de configuração com senhas reais
- Substitua todas as credenciais por variáveis de ambiente ou placeholders
- Mantenha backup dos arquivos de configuração
- Use firewall para restringir acesso às portas

## Integração com ASBC

Os arquivos de configuração do Kamailio inserem CDRs diretamente na tabela `cdrs` do PostgreSQL.

**Campos principais**:
- `calldate`: Data/hora da chamada
- `src`: Número de origem
- `dst`: Número de destino
- `duration`: Duração total
- `billsec`: Tempo faturável
- `disposition`: Status (ANSWERED, NO ANSWER, etc.)
- `customer_id`: ID do cliente
- `carrier_id`: ID da operadora
- `did_id`: DID utilizado

O sistema ASBC processa estes CDRs automaticamente para:
- Cálculo de tarifas
- Geração de faturas
- Relatórios
- Alertas

## Troubleshooting

### RTPEngine não inicia
```bash
# Verificar logs
journalctl -u rtpengine -n 50

# Verificar interface de rede
ip addr show

# Testar manualmente
rtpengine --config-file=/etc/rtpengine/rtpengine.conf --foreground
```

### Kamailio não conecta ao banco
```bash
# Testar conexão PostgreSQL
psql -h localhost -U asbc_user -d asbc

# Verificar logs
journalctl -u kamailio -n 50
```

### Sem áudio nas chamadas
```bash
# Verificar RTPEngine
systemctl status rtpengine

# Verificar firewall
sudo firewall-cmd --list-all

# Capturar pacotes RTP
sudo tcpdump -n udp portrange 10000-30000
```

## Referências

- [Documentação oficial do Kamailio](https://www.kamailio.org/docs/)
- [Documentação do RTPEngine](https://github.com/sipwise/rtpengine)
- [Guia de instalação completo](../INSTALACAO_KAMAILIO.md)
