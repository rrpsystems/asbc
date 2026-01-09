# Análise de Qualidade com Códigos SIP e Q.850

## Visão Geral

O sistema ASBC agora captura e analisa automaticamente códigos SIP e causas Q.850 de todas as chamadas, fornecendo insights detalhados sobre a qualidade das chamadas e identificação precisa de problemas.

## 📊 Onde Encontrar as Informações

### 1. Relatório de Análise de Qualidade

**Localização**: Menu → Relatórios → Análise de Qualidade (ASR/ACD)

Este relatório foi aprimorado com três novas seções:

#### Top 10 Códigos SIP
- Lista os 10 códigos SIP mais frequentes no período
- Exibe o percentual de ocorrência de cada código
- Badges coloridos por severidade:
  - **Verde**: Códigos de sucesso (200 OK)
  - **Amarelo**: Erros temporários (486 Busy Here, 487 Request Terminated)
  - **Vermelho**: Erros críticos (404 Not Found, 503 Service Unavailable, etc.)

**Exemplo de Uso**:
```
200 OK                    ████████████████████ 85%    12.450 chamadas
486 Busy Here             ███░░░░░░░░░░░░░░░░░  8%     1.170 chamadas
487 Request Terminated    ██░░░░░░░░░░░░░░░░░░  5%       730 chamadas
503 Service Unavailable   █░░░░░░░░░░░░░░░░░░░  2%       290 chamadas
```

#### Top 10 Causas Q.850
- Lista as 10 causas Q.850 mais comuns
- Identifica padrões de falha específicos
- Badges coloridos:
  - **Verde**: Desligamento normal (16 - Normal call clearing)
  - **Amarelo**: Ocupado/sem resposta (17 - User busy, 19 - No answer)
  - **Vermelho**: Outros problemas (34 - No circuit available, 41 - Temporary failure, etc.)

**Exemplo de Uso**:
```
16 Normal call clearing   ████████████████████ 75%    11.000 chamadas
17 User busy              ███░░░░░░░░░░░░░░░░░ 12%     1.760 chamadas
19 No answer from user    ██░░░░░░░░░░░░░░░░░░  8%     1.170 chamadas
34 No circuit available   █░░░░░░░░░░░░░░░░░░░  5%       730 chamadas
```

#### Tipos de Falha
- Classifica falhas automaticamente em 4 categorias:
  - **Redirecionamento (3xx)**: Chamadas redirecionadas
  - **Erro Cliente (4xx)**: Problemas originados no cliente/origem
  - **Erro Servidor (5xx)**: Problemas no servidor/destino
  - **Falha Global (6xx)**: Falhas globais de roteamento

**Exemplo de Uso**:
```
Erro Cliente (4xx)        ████████████████░░░░ 60%    1.200 chamadas
Erro Servidor (5xx)       ██████░░░░░░░░░░░░░░ 30%      600 chamadas
Redirecionamento (3xx)    ███░░░░░░░░░░░░░░░░░  8%      160 chamadas
Falha Global (6xx)        █░░░░░░░░░░░░░░░░░░░  2%       40 chamadas
```

### 2. Detalhamento de CDR

**Localização**: CDRs → Clique em qualquer chamada → Modal de Detalhes

O modal de detalhes agora inclui uma seção "Análise de Qualidade" que mostra:

- **Código SIP**: Badge colorido + descrição (ex: 200 OK)
- **Causa Q.850**: Badge colorido + descrição (ex: 16 - Normal call clearing)
- **Tipo de Falha**: Classificação automática (ex: Erro do Cliente (4xx))
- **Reason Header**: Cabeçalho completo para troubleshooting avançado

**Nota**: Esta seção só aparece se houver dados SIP/Q.850 disponíveis na chamada.

## 🔍 Como Interpretar os Códigos

### Códigos SIP Comuns

#### Sucesso (2xx)
- **200 OK**: Chamada completada com sucesso
- **202 Accepted**: Requisição aceita

#### Redirecionamento (3xx)
- **300 Multiple Choices**: Múltiplas opções disponíveis
- **301 Moved Permanently**: Número mudou permanentemente
- **302 Moved Temporarily**: Redirecionamento temporário

#### Erros do Cliente (4xx)
- **400 Bad Request**: Requisição malformada
- **403 Forbidden**: Acesso negado
- **404 Not Found**: Número não encontrado
- **408 Request Timeout**: Timeout na requisição
- **480 Temporarily Unavailable**: Temporariamente indisponível
- **486 Busy Here**: Ocupado
- **487 Request Terminated**: Requisição cancelada

#### Erros do Servidor (5xx)
- **500 Server Internal Error**: Erro interno do servidor
- **503 Service Unavailable**: Serviço indisponível
- **504 Server Time-out**: Timeout do servidor

#### Falhas Globais (6xx)
- **600 Busy Everywhere**: Ocupado em todos os lugares
- **603 Decline**: Chamada recusada
- **604 Does Not Exist Anywhere**: Não existe em lugar nenhum

### Causas Q.850 Comuns

#### Sucesso
- **16**: Normal call clearing (desligamento normal)

#### Ocupado/Sem Resposta
- **17**: User busy (usuário ocupado)
- **18**: No user responding (sem resposta do usuário)
- **19**: No answer from user (usuário não atendeu)
- **20**: Subscriber absent (assinante ausente)

#### Rejeição
- **21**: Call rejected (chamada rejeitada)
- **22**: Number changed (número mudou)

#### Problemas de Rede
- **27**: Destination out of order (destino fora de serviço)
- **28**: Invalid number format (formato de número inválido)
- **31**: Normal, unspecified (normal, não especificado)
- **34**: No circuit/channel available (sem canal disponível)
- **38**: Network out of order (rede fora de serviço)
- **41**: Temporary failure (falha temporária)
- **42**: Switching equipment congestion (congestionamento)
- **44**: Requested channel not available (canal solicitado indisponível)
- **47**: Resource unavailable (recurso indisponível)

#### Outros
- **127**: Interworking, unspecified (interoperabilidade não especificada)

## 💡 Casos de Uso Práticos

### 1. Identificar Problemas de Qualidade

**Cenário**: ASR (taxa de atendimento) está baixo

**Ação**:
1. Acesse o relatório de Análise de Qualidade
2. Verifique o "Top 10 Códigos SIP"
3. Se houver muitos códigos 503 (Service Unavailable) ou 480 (Temporarily Unavailable):
   - Problema pode estar na operadora destino
   - Verificar se há problemas de capacidade

### 2. Otimizar Rotas

**Cenário**: Decidir qual operadora usar para determinado destino

**Ação**:
1. Filtrar relatório por operadora (use o filtro)
2. Compare ASR entre operadoras
3. Analise os códigos Q.850:
   - Muitos códigos 41 (Temporary failure): Instabilidade
   - Muitos códigos 34 (No circuit available): Falta de capacidade
4. Escolha a operadora com melhor perfil de códigos

### 3. Troubleshooting de Chamadas Específicas

**Cenário**: Cliente reporta que não consegue completar chamadas

**Ação**:
1. Vá para CDRs e filtre pelo cliente
2. Clique em uma chamada falhada
3. No modal, verifique a seção "Análise de Qualidade":
   - **Código SIP 403**: Problema de autenticação/permissão
   - **Código SIP 404**: Número não existe
   - **Q.850 21**: Chamada rejeitada pelo destino
   - **Q.850 28**: Formato de número inválido
4. Use essas informações para diagnosticar o problema

### 4. Relatórios Gerenciais

**Cenário**: Preparar relatório de qualidade mensal

**Ação**:
1. Configure o período (data inicial e final)
2. Capture screenshots das seções:
   - Top 10 Códigos SIP
   - Top 10 Causas Q.850
   - Tipos de Falha
3. Use esses dados para:
   - Justificar mudanças de operadora
   - Demonstrar melhorias na qualidade
   - Identificar necessidades de expansão

### 5. Monitoramento Proativo

**Cenário**: Detectar problemas antes que clientes reclamem

**Ação**:
1. Configure verificações diárias no relatório
2. Estabeleça baselines:
   - % normal de código 200 (ex: > 80%)
   - % aceitável de 486/487 (ex: < 10%)
   - % crítico de 503 (ex: < 2%)
3. Quando métricas saírem do normal:
   - Investigue imediatamente
   - Verifique se é problema pontual ou tendência
   - Tome ações corretivas (mudança de rota, contato com operadora, etc.)

## 📈 Métricas de Referência

### Qualidade Excelente
- Códigos 200: > 85%
- Códigos 486/487: < 8%
- Códigos 503/504: < 1%
- Q.850 16 (Normal clearing): > 80%
- Q.850 17/19 (Busy/No answer): < 15%

### Qualidade Aceitável
- Códigos 200: 70-85%
- Códigos 486/487: 8-15%
- Códigos 503/504: 1-3%
- Q.850 16: 65-80%
- Q.850 17/19: 15-25%

### Qualidade Crítica (Requer Ação Imediata)
- Códigos 200: < 70%
- Códigos 486/487: > 15%
- Códigos 503/504: > 3%
- Q.850 16: < 65%
- Q.850 17/19: > 25%

## 🔧 Troubleshooting

### Dados SIP/Q.850 Não Aparecem

**Possíveis Causas**:
1. Kamailio ainda não atualizado com a configuração aprimorada
2. CDRs antigos (antes da implementação)
3. Problema na captura dos dados pelo Kamailio

**Solução**:
1. Verifique se o [base-routes.cfg](../../docs/kamailio/configs/base-routes.cfg) foi atualizado
2. Reinicie o Kamailio: `sudo systemctl restart kamailio`
3. Faça uma chamada de teste e verifique no banco se os campos foram preenchidos:
```sql
SELECT sip_code, sip_reason, q850_cause, q850_description, failure_type
FROM cdrs
WHERE calldate >= NOW() - INTERVAL '1 hour'
LIMIT 10;
```

### Percentuais Não Somam 100%

**Causa**: Os percentuais são calculados sobre totais diferentes:
- **SIP**: Percentual sobre TODAS as chamadas
- **Q.850**: Percentual sobre chamadas COM causa Q.850
- **Failure Type**: Percentual sobre chamadas COM tipo de falha

Isso é intencional para permitir análises mais precisas.

## 📚 Referências

- [RFC 3261 - SIP Protocol](https://datatracker.ietf.org/doc/html/rfc3261)
- [ITU-T Q.850 - Usage of Cause and Location](https://www.itu.int/rec/T-REC-Q.850)
- [Documentação Kamailio](../../docs/kamailio/configs/README.md)
- [Migration SIP/Q.850](../../database/migrations/2026_01_09_072349_add_sip_q850_fields_to_cdrs_table.php)

## 🎯 Próximos Passos

1. **Alertas Automáticos**: Configure alertas quando métricas ficarem críticas
2. **Dashboard em Tempo Real**: Monitore códigos SIP/Q.850 em tempo real
3. **Relatórios Agendados**: Configure envio automático de relatórios de qualidade
4. **Análise Preditiva**: Use histórico de códigos para prever problemas
5. **Integração com Tickets**: Crie tickets automaticamente para códigos críticos

---

**Última Atualização**: Janeiro 2026
**Versão do Sistema**: 2.1.0
