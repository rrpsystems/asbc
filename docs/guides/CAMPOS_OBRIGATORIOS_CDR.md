# 📋 Campos Obrigatórios da Tabela CDR para Tarifação

## 🔴 Campos CRÍTICOS (Obrigatórios)

### 1. **calldate** (timestamp)
- **Descrição**: Data e hora da chamada
- **Obrigatório**: ✅ SIM
- **Usado para**: Filtros, relatórios, fechamento mensal
- **Exemplo**: `2025-01-15 14:30:25`

### 2. **customer_id** (bigInteger)
- **Descrição**: ID do cliente que realizou a chamada
- **Obrigatório**: ✅ SIM
- **Usado para**: Associar chamada ao cliente, cálculo de fatura
- **Exemplo**: `1015`

### 3. **carrier_id** (bigInteger)
- **Descrição**: ID da operadora utilizada
- **Obrigatório**: ✅ SIM
- **Usado para**: Buscar tarifa correta, custo de operadora
- **Exemplo**: `3`

### 4. **did_id** (bigInteger)
- **Descrição**: Número DID utilizado na chamada
- **Obrigatório**: ✅ SIM
- **Usado para**: Identificar origem, filtros, relatórios
- **Exemplo**: `11940001234`

### 5. **numero** (string)
- **Descrição**: Número de destino discado (limpo, apenas dígitos)
- **Obrigatório**: ✅ SIM
- **Usado para**: Matching com prefixo da tarifa, classificação
- **Exemplo**: `11987654321` (celular) ou `1133334444` (fixo)

### 6. **billsec** (integer)
- **Descrição**: Tempo de conversação em segundos
- **Obrigatório**: ✅ SIM
- **Usado para**: Cálculo do tempo cobrado e valores
- **Exemplo**: `125` (2 minutos e 5 segundos)

### 7. **tarifa** (enum)
- **Descrição**: Tipo/classificação da chamada
- **Obrigatório**: ✅ SIM
- **Valores permitidos**: 
  - `Fixo` - Chamadas para telefone fixo
  - `Movel` - Chamadas para celular
  - `Internacional` - Chamadas internacionais
  - `Entrada` - Chamadas recebidas (não cobradas)
  - `Servico` - Números de serviço (0800, etc)
  - `Outros` - Outros tipos
  - `Gratuito` - Chamadas gratuitas
- **Usado para**: Buscar tarifa específica do tipo
- **Exemplo**: `Movel`

### 8. **ramal** (string)
- **Descrição**: Ramal que originou a chamada
- **Obrigatório**: ⚠️ RECOMENDADO
- **Usado para**: Filtros, identificação de origem interna
- **Exemplo**: `2001`

---

## 🟡 Campos Calculados/Atualizados pelo Sistema

### 9. **tempo_cobrado** (integer)
- **Descrição**: Tempo efetivamente cobrado após aplicar regras da tarifa
- **Preenchido por**: `CallTariffService::calcularTempoCobrado()`
- **Lógica**:
  ```
  Se billsec <= tempoinicial → 0
  Se billsec < tempominimo → tempominimo
  Senão → tempominimo + (incrementos × incremento)
  ```
- **Exemplo**: `120` (2 minutos cobrados)

### 10. **valor_compra** (decimal 10,4)
- **Descrição**: Custo da chamada (valor pago à operadora)
- **Preenchido por**: `CallTariffService::calcularValor()`
- **Fórmula**: `(tempo_cobrado × compra/60) + vconexao`
- **Exemplo**: `0.4500` (R$ 0,45)

### 11. **valor_venda** (decimal 10,4)
- **Descrição**: Valor cobrado do cliente
- **Preenchido por**: `CallTariffService::calcularValor()`
- **Fórmula**: `(tempo_cobrado × venda/60) + vconexao`
- **Exemplo**: `1.2000` (R$ 1,20)

### 12. **status** (string)
- **Descrição**: Status do processamento
- **Valores**:
  - `Pendente` - Aguardando tarifação (padrão)
  - `Processada` - Tarifada com sucesso
  - `Erro_Tarifa` - Erro ao tarifar (tarifa não encontrada)
  - `Erro` - Erro genérico
- **Atualizado por**: `CallTariffJob`
- **Exemplo**: `Processada`

---

## 🟢 Campos Opcionais (Úteis mas não obrigatórios)

### 13. **tipo** (enum)
- **Valores**: `Entrada`, `Saida`
- **Usado para**: Classificação e filtros
- **Exemplo**: `Saida`

### 14. **desligamento** (string)
- **Valores**: `Origem`, `Destino`
- **Usado para**: Análise de qualidade
- **Exemplo**: `Origem`

### 15. **disposition** (string)
- **Descrição**: Status da chamada (Asterisk)
- **Valores**: `ANSWERED`, `NO ANSWER`, `BUSY`, `FAILED`
- **Usado para**: Filtrar chamadas atendidas
- **Exemplo**: `ANSWERED`

### 16. **duration** (integer)
- **Descrição**: Duração total (ring + conversa)
- **Usado para**: Análise completa da chamada
- **Exemplo**: `135`

### 17. **recordingfile** (string)
- **Descrição**: Caminho do arquivo de gravação
- **Exemplo**: `/var/spool/asterisk/monitor/2025/01/15/1015-11987654321-20250115-143025.wav`

### 18. **uniqueid** (string)
- **Descrição**: ID único da chamada no Asterisk
- **Usado para**: Rastreamento, debug
- **Exemplo**: `1736956225.123456`

### 19. Campos de Qualidade:
- **mes_tx / mes_rx** (decimal): Qualidade MOS
- **ip_src / ip_dst**: IPs SIP
- **ip_rtp_src / ip_rtp_dst**: IPs RTP
- **codec_nativo / codec_in / codec_out**: Codecs utilizados
- **hangup**: Causa ISDN de desconexão

---

## 📊 Exemplo Completo de CDR Mínimo

```json
{
  "calldate": "2025-01-15 14:30:25",
  "customer_id": 1015,
  "carrier_id": 3,
  "did_id": "11940001234",
  "numero": "11987654321",
  "billsec": 125,
  "tarifa": "Movel",
  "ramal": "2001",
  "tipo": "Saida",
  "disposition": "ANSWERED",
  "desligamento": "Origem",
  "status": "Pendente"
}
```

---

## 🔄 Fluxo de Processamento

1. **CDR Criado** com status `Pendente`
2. **CallTariffJob** disparado
3. **Busca Tarifa** usando:
   - `carrier_id` → Operadora
   - `tarifa` → Tipo (Fixo/Movel/etc)
   - `numero` → Prefixo (match mais longo)
4. **Calcula**:
   - `tempo_cobrado` (baseado em tempoinicial, tempominimo, incremento)
   - `valor_compra` (custo × tempo + conexão)
   - `valor_venda` (venda × tempo + conexão)
5. **Atualiza CDR**:
   - `status` = `Processada`
   - Valores calculados salvos
6. **Resumo Mensal** atualizado (MonthlyRevenueSummaryService)

---

## ⚠️ Regras de Negócio

### Cálculo de Tempo Cobrado:
```php
if (billsec <= rate->tempoinicial) {
    tempo_cobrado = 0; // Chamadas curtas não cobradas
}
else if (billsec < rate->tempominimo) {
    tempo_cobrado = rate->tempominimo; // Cobra tempo mínimo
}
else {
    tempo_extra = billsec - rate->tempominimo;
    incrementos = ceil(tempo_extra / rate->incremento);
    tempo_cobrado = rate->tempominimo + (incrementos × rate->incremento);
}
```

### Exemplo Prático:
**Tarifa Configurada:**
- `tempoinicial` = 6 segundos (carência)
- `tempominimo` = 30 segundos
- `incremento` = 6 segundos
- `compra` = R$ 0,20/min
- `vconexao` = R$ 0,05

**Chamada Real:**
- `billsec` = 125 segundos

**Cálculo:**
1. 125 > 6 (passou carência)
2. 125 > 30 (passou tempo mínimo)
3. Extra: 125 - 30 = 95 segundos
4. Incrementos: ceil(95/6) = 16
5. Tempo cobrado: 30 + (16 × 6) = 126 segundos
6. Valor: (126 × 0,20/60) + 0,05 = **R$ 0,47**

---

## 🚨 Erros Comuns

### ❌ CDR sem tarifa:
- Falta prefixo cadastrado para o número
- Carrier sem tarifa para o tipo (Fixo/Movel)
- Status fica como `Erro_Tarifa`

### ❌ Campos NULL críticos:
- `customer_id` NULL → Não gera fatura
- `carrier_id` NULL → Não encontra tarifa
- `numero` NULL → Não faz matching
- `billsec` NULL → Cálculo incorreto

### ❌ Tarifa classificada errada:
- Número mobile classificado como `Fixo`
- Busca tarifa errada
- Valor incorreto

---

## 🎯 Checklist de Importação

Ao importar CDRs, garantir:
- [ ] `calldate` formatado corretamente
- [ ] `customer_id` existente na tabela customers
- [ ] `carrier_id` existente na tabela carriers
- [ ] `did_id` validado (número DID)
- [ ] `numero` limpo (apenas dígitos, sem formatação)
- [ ] `billsec` em segundos (inteiro)
- [ ] `tarifa` classificada corretamente
- [ ] `status` = `Pendente` para processamento
- [ ] `disposition` = `ANSWERED` para chamadas completadas

---

## 📚 Referências

- **Migration**: `database/migrations/2024_09_16_173145_create_cdrs_table.php`
- **Service**: `app/Services/CallTariffService.php`
- **Job**: `app/Jobs/CallTariffJob.php`
- **Model**: `app/Models/Cdr.php`
