# 🌐 Configuração de Proxy/Porta - Abordagem Híbrida

## 📋 Resumo da Implementação

Foi implementada uma **abordagem híbrida** para configuração de Proxy, Porta, Domínio e Tech Prefix, permitindo configurações tanto no nível de **Cliente** (padrão) quanto no nível de **DID** (específico).

---

## 🎯 Como Funciona

### 1️⃣ **Configuração no Cliente (Padrão)**

Ao criar ou editar um cliente, você pode definir:
- **Proxy Padrão**: Endereço do SBC (ex: `sbc.rrpsystems.com.br`)
- **Porta Padrão**: Porta SIP (ex: `5060`, `5099`)
- **Domínio Padrão**: Domínio VoIP (ex: `voip.cliente.com.br`)
- **Tech Prefix Padrão**: Prefixo técnico (ex: `9`, `0`, `00`)

**Todos os DIDs deste cliente herdarão essas configurações por padrão.**

### 2️⃣ **Configuração no DID (Específico)**

Ao criar ou editar um DID, você pode:
- **Deixar vazio**: DID herda a configuração do cliente
- **Preencher**: DID usa configuração específica (sobrescreve o padrão)

---

## 🔄 Fluxo de Trabalho

### Cenário 1: Uso Padrão (Mais Comum)

```
1. Criar Cliente
   └─ Proxy: sbc.rrpsystems.com.br
   └─ Porta: 5060

2. Criar DID (5511999998888)
   └─ Proxy: [vazio]
   └─ Porta: [vazio]
   
3. Resultado
   └─ DID usa: sbc.rrpsystems.com.br:5060
```

### Cenário 2: Configuração Específica

```
1. Cliente tem configuração padrão
   └─ Proxy: sbc.rrpsystems.com.br
   └─ Porta: 5060

2. Criar DID especial (5511999997777)
   └─ Proxy: sbc2.rrpsystems.com.br
   └─ Porta: 5099
   
3. Resultado
   └─ Este DID específico usa: sbc2.rrpsystems.com.br:5099
   └─ Outros DIDs continuam usando: sbc.rrpsystems.com.br:5060
```

---

## 💻 Como Usar no Código

### Obter Configuração Ativa de um DID

```php
$did = Did::find($id);

// Método 1: Usar os métodos
$proxy = $did->getProxyAtivo();      // Retorna proxy do DID ou do customer
$porta = $did->getPortaAtiva();      // Retorna porta do DID ou do customer
$dominio = $did->getDominioAtivo();
$techprefix = $did->getTechprefixAtivo();

// Método 2: Usar os accessors (mais direto)
$proxy = $did->proxy_ativo;
$porta = $did->porta_ativa;
$dominio = $did->dominio_ativo;
$techprefix = $did->techprefix_ativo;

// Verificar se usa configuração específica
if ($did->usaConfiguracaoEspecifica()) {
    echo "Este DID tem configuração própria";
} else {
    echo "Este DID herda do cliente";
}
```

### Exemplo Prático: Provisionar no SBC

```php
$did = Did::with('customer')->find($id);

$configuracaoSBC = [
    'numero' => $did->did,
    'proxy' => $did->proxy_ativo,
    'porta' => $did->porta_ativa,
    'dominio' => $did->dominio_ativo,
    'techprefix' => $did->techprefix_ativo,
    'customer' => $did->customer->razaosocial,
];

// Envia para o SBC via API
SBCApi::provisionar($configuracaoSBC);
```

---

## 🗄️ Estrutura do Banco de Dados

### Tabela `customers`
```sql
- proxy_padrao (VARCHAR, nullable)
- porta_padrao (INTEGER, nullable, default: 5060)
- dominio_padrao (VARCHAR, nullable)
- techprefix_padrao (VARCHAR, nullable)
```

### Tabela `dids`
```sql
- proxy (VARCHAR, nullable)
- porta (INTEGER, nullable)
- dominio (VARCHAR, nullable)
- techprefix (VARCHAR, nullable)
```

---

## 🚀 Migration

Para aplicar as mudanças no banco de dados:

```bash
php artisan migrate
```

A migration `2025_12_01_000001_add_proxy_porta_to_customers_and_dids.php` adiciona todos os campos necessários.

---

## 📱 Interface do Usuário

### Formulário de Cliente

- Seção "Configurações SBC (Padrão)" com 4 campos:
  - Proxy Padrão
  - Porta Padrão
  - Domínio Padrão
  - Tech Prefix Padrão

### Formulário de DID

- Seção "Configurações SBC (Específicas)" com:
  - **Indicador visual** mostrando configuração ativa
  - **Alerta informativo** se herdando do cliente ou usando específica
  - 4 campos editáveis (vazio = herda do cliente)

---

## ✅ Benefícios

1. **Produtividade**: Configure uma vez no cliente, todos os DIDs herdam
2. **Flexibilidade**: DIDs podem ter configuração específica quando necessário
3. **Manutenção**: Alterar proxy do cliente atualiza todos os DIDs que herdam
4. **Visibilidade**: Interface mostra claramente qual configuração está ativa
5. **Escalabilidade**: Suporta cenários simples e complexos

---

## 📝 Exemplos de Uso

### 1. Cliente Simples (Todos DIDs no Mesmo SBC)

```
Cliente: Empresa ABC
├── Proxy: sbc.rrpsystems.com.br
└── Porta: 5060

DIDs:
├── 5511999998888 → sbc.rrpsystems.com.br:5060
├── 5511999997777 → sbc.rrpsystems.com.br:5060
└── 5511999996666 → sbc.rrpsystems.com.br:5060
```

### 2. Cliente com DIDs em Múltiplos SBCs

```
Cliente: Empresa XYZ
├── Proxy: sbc1.rrpsystems.com.br (padrão)
└── Porta: 5060 (padrão)

DIDs:
├── 5511999998888 → sbc1.rrpsystems.com.br:5060 (herda)
├── 5511999997777 → sbc2.rrpsystems.com.br:5099 (específico)
└── 5511999996666 → sbc1.rrpsystems.com.br:5060 (herda)
```

### 3. Migração Gradual entre SBCs

```
Passo 1: Alterar configuração de DIDs específicos
Passo 2: Testar
Passo 3: Se OK, alterar o padrão do cliente
Passo 4: DIDs restantes migram automaticamente
```

---

## 🔍 Troubleshooting

### DID não está usando configuração correta

```php
$did = Did::with('customer')->find($id);

echo "Proxy do DID: " . ($did->proxy ?? 'null') . "\n";
echo "Proxy do Cliente: " . ($did->customer->proxy_padrao ?? 'null') . "\n";
echo "Proxy Ativo: " . $did->proxy_ativo . "\n";
```

### Atualizar configuração de todos os DIDs de um cliente

```php
// Não é necessário! DIDs sem configuração específica herdam automaticamente
// Mas se quiser forçar atualização:
$customer = Customer::find($id);
$customer->update([
    'proxy_padrao' => 'novo-sbc.rrpsystems.com.br',
    'porta_padrao' => 5099
]);

// Todos os DIDs sem proxy/porta específicos usarão os novos valores
```

---

## 📚 Arquivos Modificados

### Models
- `app/Models/Customer.php` - Adicionados campos fillable e padrões
- `app/Models/Did.php` - Adicionados campos, métodos getters e accessors
- `app/Models/Carrier.php` - Adicionados campos proxy e porta

### Controllers (Livewire)
- `app/Livewire/Customers/Create.php`
- `app/Livewire/Customers/Update.php`
- `app/Livewire/Dids/Create.php`
- `app/Livewire/Dids/Update.php`
- `app/Livewire/Carriers/Create.php`
- `app/Livewire/Carriers/Update.php`

### Views
- `resources/views/livewire/customers/form.blade.php`
- `resources/views/livewire/dids/form.blade.php`
- `resources/views/livewire/carriers/form.blade.php`

### Migrations
- `database/migrations/2025_12_01_000001_add_proxy_porta_to_customers_and_dids.php`

---

**Desenvolvido com ❤️ para ASBC RRP Systems**
