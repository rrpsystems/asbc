# Documentação do ASBC

Índice completo da documentação do projeto ASBC - Advanced SBC Billing & Management System.

## 📚 Índice Geral

- [Guias de Início Rápido](#-guias-de-início-rápido)
- [Arquitetura e Padrões](#-arquitetura-e-padrões)
- [Guias e Tutoriais](#-guias-e-tutoriais)
- [Implementações e Otimizações](#-implementações-e-otimizações)
- [Análises Técnicas](#-análises-técnicas)
- [Testes](#-testes)
- [Integrações](#-integrações)

---

## 🚀 Guias de Início Rápido

### Instalação
- **[Guia de Instalação](guides/INSTALACAO.md)** - Instalação completa do ASBC
- **[Quick Start - Tarifação](guides/QUICK_START_TARIFACAO.md)** - Início rápido do sistema de tarifação

### Configuração Inicial
- **[Campos Obrigatórios CDR](guides/CAMPOS_OBRIGATORIOS_CDR.md)** - Campos necessários para CDRs
- **[Configuração Proxy/Porta](guides/CONFIGURACAO_PROXY_PORTA.md)** - Configuração de proxy e portas

---

## 🏗️ Arquitetura e Padrões

### Arquitetura do Sistema
- **[Arquitetura Backend](architecture/BACKEND_ARCHITECTURE.md)** - Estrutura e organização do backend
- **[Padrões de UI](architecture/UI_STANDARDS.md)** - Guia de padrões de interface

### Sistemas Principais
- **[Sistema de Tarifação](architecture/SISTEMA_TARIFACAO.md)** - Arquitetura do sistema de tarifação
- **[Sistema de Revendas](architecture/SISTEMA_REVENDAS.md)** - Arquitetura multi-tenant de revendas

---

## 📖 Guias e Tutoriais

### Importação e Processamento
- **[Guia de Importação de CDRs](guides/GUIA_IMPORTACAO_CDRS.md)** - Como importar CDRs do Asterisk/Kamailio
- **[Tarifação em Batch](guides/TARIFACAO_BATCH.md)** - Processamento otimizado em lote

### Funcionalidades Específicas
- **[Painel de Revenda Completo - Fase 4](guides/FASE_4_PAINEL_REVENDA_COMPLETO.md)** - Implementação completa do painel de revendas
- **[Análise de Qualidade SIP/Q.850](guides/ANALISE_QUALIDADE_SIP_Q850.md)** - Guia completo de análise de qualidade com códigos SIP e Q.850

---

## 🔧 Implementações e Otimizações

### Otimizações de Tarifação
- **[Melhorias no Tariff Service](implementation/IMPLEMENTACAO_MELHORIAS_TARIFF.md)** - Otimizações no serviço de tarifação
- **[Otimização Monthly Revenue](implementation/IMPLEMENTACAO_MONTHLY_REVENUE_OPTIMIZATION.md)** - Otimização do processamento de receita mensal
- **[Resumo de Otimização Revenue](implementation/RESUMO_OTIMIZACAO_REVENUE.md)** - Resumo das otimizações de receita

### Carrier e Custos
- **[Otimização Carrier Cost](implementation/IMPLEMENTACAO_CARRIER_COST_OPTIMIZATION.md)** - Otimização de custos de operadora
- **[Consolidação Carrier Usage](implementation/IMPLEMENTACAO_CARRIER_USAGE_CONSOLIDACAO.md)** - Consolidação de uso de operadoras

### Faturas e Receitas
- **[Fechar/Reabrir Faturas](implementation/IMPLEMENTACAO_FECHAR_REABRIR_FATURAS.md)** - Sistema de fechamento e reabertura de faturas
- **[Monthly Revenue Service](implementation/IMPLEMENTACAO_MONTHLY_REVENUE_SERVICE.md)** - Implementação do serviço de receita mensal
- **[Adição Revenue Reprocess](implementation/ADICAO_REVENUE_REPROCESS_MANUTENCAO.md)** - Reprocessamento de receitas

### Relatórios e Alertas
- **[Melhoria Relatórios Operadora](implementation/MELHORIA_RELATORIOS_OPERADORA_CUSTOMIZADO.md)** - Relatórios customizados de operadora
- **[Otimização Check Alerts](implementation/OTIMIZACAO_CHECK_ALERTS.md)** - Otimização do sistema de alertas

### Manutenção
- **[Deprecação Comando Duplicado](implementation/DEPRECACAO_COMANDO_DUPLICADO.md)** - Remoção de comandos duplicados

---

## 🔍 Análises Técnicas

### Análise de Serviços
- **[Análise Call Tariff Service](analysis/ANALISE_CALL_TARIFF_SERVICE.md)** - Análise detalhada do serviço de tarifação
- **[Análise Carrier Cost Allocation](analysis/ANALISE_CARRIER_COST_ALLOCATION_SERVICE.md)** - Análise de alocação de custos
- **[Análise Carrier Usage Service](analysis/ANALISE_CARRIER_USAGE_SERVICE.md)** - Análise do serviço de uso de operadoras
- **[Análise Monthly Revenue Service](analysis/ANALISE_MONTHLY_REVENUE_SERVICE.md)** - Análise do serviço de receita mensal

### Análises Comparativas
- **[Comparativo Revenue Job vs Service](analysis/ANALISE_COMPARATIVA_REVENUE_JOB_VS_SERVICE.md)** - Comparação entre Job e Service de receita

---

## 🧪 Testes

### Testes de Funcionalidades
- **[Teste Fechar Faturas](tests/TESTE_FECHAR_FATURAS.md)** - Testes do sistema de fechamento de faturas

---

## 🔌 Integrações

### Kamailio SBC
- **[Instalação do Kamailio](kamailio/INSTALACAO_KAMAILIO.md)** - Guia completo de instalação do Kamailio 6 + RTPEngine
- **[Configurações do Kamailio](kamailio/configs/README.md)** - Documentação dos arquivos de configuração

---

## 📊 Estrutura de Pastas

```
docs/
├── README.md                    # Este arquivo
├── architecture/                # Arquitetura e padrões do sistema
│   ├── BACKEND_ARCHITECTURE.md
│   ├── UI_STANDARDS.md
│   ├── SISTEMA_TARIFACAO.md
│   └── SISTEMA_REVENDAS.md
├── guides/                      # Guias e tutoriais
│   ├── INSTALACAO.md
│   ├── GUIA_IMPORTACAO_CDRS.md
│   ├── QUICK_START_TARIFACAO.md
│   ├── TARIFACAO_BATCH.md
│   ├── CAMPOS_OBRIGATORIOS_CDR.md
│   ├── CONFIGURACAO_PROXY_PORTA.md
│   └── FASE_4_PAINEL_REVENDA_COMPLETO.md
├── implementation/              # Implementações e otimizações
│   ├── IMPLEMENTACAO_MELHORIAS_TARIFF.md
│   ├── IMPLEMENTACAO_CARRIER_COST_OPTIMIZATION.md
│   ├── IMPLEMENTACAO_CARRIER_USAGE_CONSOLIDACAO.md
│   ├── IMPLEMENTACAO_FECHAR_REABRIR_FATURAS.md
│   ├── IMPLEMENTACAO_MONTHLY_REVENUE_OPTIMIZATION.md
│   ├── IMPLEMENTACAO_MONTHLY_REVENUE_SERVICE.md
│   ├── ADICAO_REVENUE_REPROCESS_MANUTENCAO.md
│   ├── MELHORIA_RELATORIOS_OPERADORA_CUSTOMIZADO.md
│   ├── OTIMIZACAO_CHECK_ALERTS.md
│   ├── RESUMO_OTIMIZACAO_REVENUE.md
│   └── DEPRECACAO_COMANDO_DUPLICADO.md
├── analysis/                    # Análises técnicas
│   ├── ANALISE_CALL_TARIFF_SERVICE.md
│   ├── ANALISE_CARRIER_COST_ALLOCATION_SERVICE.md
│   ├── ANALISE_CARRIER_USAGE_SERVICE.md
│   ├── ANALISE_MONTHLY_REVENUE_SERVICE.md
│   └── ANALISE_COMPARATIVA_REVENUE_JOB_VS_SERVICE.md
├── tests/                       # Documentação de testes
│   └── TESTE_FECHAR_FATURAS.md
└── kamailio/                    # Integração Kamailio
    ├── INSTALACAO_KAMAILIO.md
    └── configs/
        ├── README.md
        └── rtpengine.conf
```

---

## 🆘 Precisa de Ajuda?

- **Instalação:** Comece pelo [Guia de Instalação](guides/INSTALACAO.md)
- **Tarifação:** Veja o [Quick Start de Tarifação](guides/QUICK_START_TARIFACAO.md)
- **Arquitetura:** Consulte a [Arquitetura Backend](architecture/BACKEND_ARCHITECTURE.md)
- **Revendas:** Leia sobre o [Sistema de Revendas](architecture/SISTEMA_REVENDAS.md)
- **Kamailio:** Siga a [Instalação do Kamailio](kamailio/INSTALACAO_KAMAILIO.md)

---

## 📝 Contribuindo com a Documentação

Ao adicionar nova documentação:

1. **Escolha a pasta apropriada:**
   - `architecture/` - Arquitetura, padrões e design
   - `guides/` - Tutoriais, guias passo a passo
   - `implementation/` - Detalhes de implementação, otimizações
   - `analysis/` - Análises técnicas de componentes
   - `tests/` - Documentação de testes
   - `kamailio/` - Integração com Kamailio

2. **Siga o padrão de nomenclatura:**
   - Use MAIÚSCULAS para nomes de arquivos
   - Separe palavras com underline: `NOME_DO_ARQUIVO.md`
   - Use nomes descritivos e específicos

3. **Atualize este índice:**
   - Adicione link na seção apropriada
   - Mantenha ordem alfabética quando possível
   - Inclua breve descrição do conteúdo

---

**Última atualização:** 2025-01-04
