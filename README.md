# ASBC - Advanced SBC Billing & Management System

![Laravel](https://img.shields.io/badge/Laravel-12.42.0-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4.13-777BB4?style=flat&logo=php)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat&logo=postgresql)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat&logo=livewire)

Sistema completo de gerenciamento e faturamento para Session Border Controllers (SBC) com integração Asterisk ou kamailio, tarifação em tempo real, gestão de revendas e relatórios avançados.

## 📋 Índice

- [Características](#-características)
- [Arquitetura](#-arquitetura)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Configuração](#-configuração)
- [Módulos](#-módulos)
- [Sistema de Revendas](#-sistema-de-revendas)
- [Tarifação](#-tarifação)
- [Relatórios](#-relatórios)
- [Documentação](#-documentação)
- [Licença](#-licença)

## 🚀 Características

### Gestão Completa de SBC
- ✅ Gerenciamento de clientes, operadoras e DIDs
- ✅ Controle de canais simultâneos
- ✅ Bloqueio de entrada/saída por cliente
- ✅ Gestão de produtos e serviços
- ✅ Controle de planos e franquias

### Sistema de Tarifação Inteligente
- ✅ Processamento de CDRs em tempo real
- ✅ Tarifação batch otimizada (até 10.000 CDRs/minuto)
- ✅ Cache de tarifas para alta performance
- ✅ Cálculo automático de custos e receitas
- ✅ Suporte a múltiplos destinos e operadoras

### Gestão de Revendas
- ✅ Sistema multi-tenant com autonomia total
- ✅ Configuração de markups por tipo de serviço
- ✅ Dashboard exclusivo para revendas
- ✅ Relatórios de comissão e lucro
- ✅ Gerenciamento de clientes por revenda

### Faturamento e Financeiro
- ✅ Geração automática de faturas mensais
- ✅ Detalhamento completo de chamadas
- ✅ Cálculo de receitas e custos
- ✅ Relatórios de rentabilidade
- ✅ Previsão de faturamento

### Monitoramento e Alertas
- ✅ Sistema de alertas configurável
- ✅ Detecção de fraudes
- ✅ Análise de qualidade (ASR/ACD)
- ✅ Monitoramento de tráfego
- ✅ Dashboard financeiro em tempo real

## 🏗️ Arquitetura

### Stack Tecnológico

**Backend:**
- Laravel 12.42.0
- PHP 8.4.13
- PostgreSQL 16 com PostGIS
- Livewire 3.x para componentes reativos

**Frontend:**
- TailwindCSS 3.x
- Alpine.js
- TallStackUI para componentes

**Integrações:**
- Asterisk SBC (CDRs)
- API CNPJ.ws para validação

### Estrutura de Dados

```
┌─────────────┐
│  Customers  │─┐
└─────────────┘ │
                │  ┌──────────┐
┌─────────────┐ ├─▶│   CDRs   │
│  Resellers  │─┘  └──────────┘
└─────────────┘        │
                       ▼
┌─────────────┐  ┌──────────────────┐
│  Carriers   │─▶│ Revenue Summary  │
└─────────────┘  └──────────────────┘
                       │
┌─────────────┐        ▼
│    Rates    │─▶  ┌──────────┐
└─────────────┘    │ Invoices │
                   └──────────┘
```

## 💻 Requisitos

### Mínimos
- PHP >= 8.4
- PostgreSQL >= 14
- Composer
- Node.js >= 18
- NPM/Yarn

### Recomendados
- PHP 8.4.13
- PostgreSQL 16 com PostGIS
- Redis (para cache)
- Supervisor (para queues)

## 📦 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/rrpsystems/asbc.git
cd asbc
```

### 2. Instale as dependências

```bash
composer install
npm install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados

Edite o arquivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=asbc
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as migrações

```bash
php artisan migrate
```

### 6. Compile os assets

```bash
npm run build
```

### 7. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## ⚙️ Configuração

### Instalação e Configuração do Kamailio

Para instalação completa do Kamailio 6 + RTPEngine com integração ao ASBC, consulte:

📖 **[Documentação de Instalação do Kamailio](docs/kamailio/INSTALACAO_KAMAILIO.md)**

Esta documentação inclui:
- Preparação do ambiente e otimizações de sistema
- Instalação do PostgreSQL 17
- Instalação e configuração do Kamailio 6
- Instalação e configuração do RTPEngine com suporte a G.729
- Arquivos de configuração prontos para uso
- Guia de troubleshooting

### Conexão com SBC (Asterisk/Kamailio)

Adicione a conexão do SBC no `.env`:

```env
DB_SBC_CONNECTION=pgsql
DB_SBC_HOST=ip_do_sbc
DB_SBC_PORT=5432
DB_SBC_DATABASE=asterisk
DB_SBC_USERNAME=usuario_sbc
DB_SBC_PASSWORD=senha_sbc
```

### Importação de CDRs

Para importar CDRs do Asterisk:

```bash
# Importação manual
php artisan cdr:import

# Agendar importação automática (adicione ao crontab)
* * * * * cd /path/to/asbc && php artisan schedule:run >> /dev/null 2>&1
```

### Processamento de Tarifação

```bash
# Processar CDRs pendentes
php artisan tariff:process

# Processar em lote (batch)
php artisan tariff:batch --limit=10000
```

### Geração de Faturas

```bash
# Gerar faturas do mês anterior
php artisan revenue:generate

# Gerar fatura específica
php artisan revenue:generate --customer=123 --month=12 --year=2024
```

## 📚 Módulos

### Dashboard
- Visão geral financeira
- Resumo de chamadas
- Indicadores de performance
- Gráficos e estatísticas

### Gestão de Clientes
- Cadastro completo (CNPJ integrado)
- Configuração de planos e franquias
- Gestão de produtos/serviços
- Controle de bloqueios
- Atribuição de revendas

### Gestão de DIDs
- Associação de DIDs a clientes
- Configuração de proxy/porta
- Bloqueio individual
- Listagem e filtros avançados

### Operadoras (Carriers)
- Cadastro de operadoras
- Configuração de custos
- Planos e franquias
- Alocação de custos

### Tarifas (Rates)
- Tarifação por destino
- Configuração de custos/vendas
- Valores de conexão
- Cache otimizado

## 🏪 Sistema de Revendas

### Características
- **Autonomia Total:** Revendas configuram seus próprios markups
- **Multi-Tenant:** Dados completamente isolados por revenda
- **Markups Flexíveis:** Percentual ou valor fixo por tipo de serviço
- **Dashboard Exclusivo:** Interface dedicada para revendas

### Configuração de Markups

As revendas podem configurar:
- Markup de chamadas (%)
- Markup de produtos (%)
- Markup de planos (%)
- Markup de DIDs (%)
- Valores fixos opcionais (sobrescreve %)

### Estrutura de Preços

```
Operadora → Provider → Revenda → Cliente Final

valor_compra (custo da operadora)
    ↓
valor_venda (preço do provider para revenda)
    ↓
valor_venda_final (preço da revenda para cliente)
    ↓
valor_markup (lucro da revenda)
```

### Relatórios de Revenda

- Resumo financeiro mensal
- Detalhamento por cliente
- Análise de comissões
- Top clientes
- Relatório diário

**Documentação completa:** [SISTEMA_REVENDAS.md](SISTEMA_REVENDAS.md)

## 💰 Tarifação

### Processamento de CDRs

O sistema oferece dois modos de processamento:

#### 1. Tempo Real (Individual)
```bash
php artisan tariff:process
```
- Processa CDRs um a um
- Ideal para baixo volume
- ~100 CDRs/minuto

#### 2. Batch (Lote)
```bash
php artisan tariff:batch --limit=10000
```
- Processamento em lote otimizado
- Alta performance
- ~10.000 CDRs/minuto
- Uso de cache de tarifas

### Cálculo de Tarifas

```php
// Para cada CDR
tempo_cobrado = cálculo baseado em incremento
valor_venda = (tempo_cobrado * tarifa_minuto) + valor_conexão
valor_compra = (tempo_cobrado * custo_minuto) + custo_conexão

// Se cliente tem revenda
valor_venda_final = valor_venda * (1 + markup_revenda / 100)
valor_markup = valor_venda_final - valor_venda
```

### Campos de CDR

- `valor_compra` - Custo da operadora
- `valor_venda` - Preço base (sem markup)
- `valor_venda_final` - Preço final (com markup)
- `valor_markup` - Lucro da revenda

**Documentação completa:** [SISTEMA_TARIFACAO.md](SISTEMA_TARIFACAO.md)

## 📊 Relatórios

### Faturas
- Detalhamento de chamadas por cliente
- Resumo de produtos e serviços
- Totalização por período
- Exportação PDF

### Operadoras
- Consumo por operadora
- Análise de custos
- Alocação de despesas
- Comparativo de períodos

### Análises Avançadas
- **Qualidade (ASR/ACD):** Taxa de atendimento e duração média
- **Rentabilidade:** Análise de margem e lucro
- **Previsão:** Projeção de faturamento
- **Fraude:** Detecção de padrões anômalos
- **Rotas (LCR):** Análise de least cost routing

### Dashboard Financeiro
- Receitas x Despesas
- Evolução mensal
- Top clientes
- Indicadores de performance

## 📖 Documentação

Toda a documentação técnica está organizada na pasta **[docs/](docs/)**:

### 📋 Índice Completo
- **[📚 Documentação Completa](docs/README.md)** - Índice geral de toda a documentação

### 🚀 Início Rápido
- **[Guia de Instalação](docs/guides/INSTALACAO.md)** - Instalação completa do ASBC
- **[Quick Start - Tarifação](docs/guides/QUICK_START_TARIFACAO.md)** - Início rápido do sistema de tarifação
- **[Instalação do Kamailio](docs/kamailio/INSTALACAO_KAMAILIO.md)** - Guia completo Kamailio 6 + RTPEngine

### 🏗️ Arquitetura
- **[Arquitetura Backend](docs/architecture/BACKEND_ARCHITECTURE.md)** - Estrutura e organização do backend
- **[Sistema de Tarifação](docs/architecture/SISTEMA_TARIFACAO.md)** - Arquitetura do sistema de tarifação
- **[Sistema de Revendas](docs/architecture/SISTEMA_REVENDAS.md)** - Arquitetura multi-tenant de revendas
- **[Padrões de UI](docs/architecture/UI_STANDARDS.md)** - Guia de padrões de interface

### 📖 Guias e Tutoriais
- **[Importação de CDRs](docs/guides/GUIA_IMPORTACAO_CDRS.md)** - Como importar CDRs do Asterisk/Kamailio
- **[Tarifação em Batch](docs/guides/TARIFACAO_BATCH.md)** - Processamento otimizado em lote
- **[Configuração Proxy/Porta](docs/guides/CONFIGURACAO_PROXY_PORTA.md)** - Configuração de proxy e portas

### 🔧 Implementações e Análises
- **[Implementações](docs/implementation/)** - Detalhes de implementações e otimizações
- **[Análises Técnicas](docs/analysis/)** - Análises detalhadas de componentes do sistema

## 🔐 Segurança

### Níveis de Acesso

- **ADMIN:** Acesso total ao sistema
- **MANAGER:** Gerenciamento de clientes
- **RESELLER:** Dashboard e gestão de revenda
- **CUSTOMER:** (Futuro) Acesso limitado a dados próprios

### Proteções Implementadas

- Autenticação Laravel Breeze
- Validação de dados em todas as camadas
- Scoping por revenda/cliente
- Sanitização de inputs
- Proteção CSRF

## 🚦 Performance

### Otimizações

- ✅ Cache de tarifas (Redis)
- ✅ Processamento batch de CDRs
- ✅ Índices otimizados no banco
- ✅ Eager loading de relacionamentos
- ✅ Query optimization

### Capacidade

- **Processamento:** 10.000 CDRs/minuto (batch)
- **Clientes:** Ilimitado (testado com 1000+)
- **Revendas:** Ilimitado (multi-tenant)
- **CDRs:** Milhões (particionamento futuro)

## 🛠️ Desenvolvimento

### Ambiente de Desenvolvimento

```bash
# Instalar dependências de desenvolvimento
composer install
npm install

# Rodar testes
php artisan test

# Watch assets
npm run dev
```

### Estrutura de Pastas

```
app/
├── Console/Commands/      # Comandos Artisan
├── Enums/                # Enumerações
├── Events/               # Eventos do sistema
├── Helpers/              # Funções auxiliares
├── Http/Controllers/     # Controllers HTTP
├── Jobs/                 # Jobs de fila
├── Livewire/            # Componentes Livewire
├── Models/              # Models Eloquent
├── Observers/           # Observers
└── Services/            # Camada de serviços
```

## 🤝 Contribuindo

Contribuições são bem-vindas! Por favor:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Changelog

### v2.0.0 (2025-01-04)
- ✨ Sistema completo de revendas com autonomia
- ✨ Dashboard exclusivo para revendas
- ✨ Relatórios de comissão e lucro
- ✨ Tarifação batch otimizada (10k CDRs/min)
- ✨ Dashboard financeiro
- ✨ Sistema de alertas
- 🐛 Correção na validação de senha de clientes
- 🐛 Correção no botão de criação de clientes
- 📝 Documentação completa

### v1.0.0 (2024-12-01)
- 🎉 Release inicial
- ✨ Gestão de clientes e operadoras
- ✨ Sistema de tarifação
- ✨ Geração de faturas
- ✨ Relatórios básicos

## 📄 Licença

Este projeto é proprietário da RRP Systems.

Copyright © 2024-2025 RRP Systems. Todos os direitos reservados.

---

## 📞 Suporte

Para suporte técnico ou dúvidas:

- 📧 Email: suporte@rrpsystems.com.br
- 🌐 Website: https://rrpsystems.com.br
- 📱 GitHub Issues: https://github.com/rrpsystems/asbc/issues

---

**Desenvolvido com ❤️ por RRP Systems**
