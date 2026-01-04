# Padrões de UI - ASBC System

## Índice
1. [Containers de Página](#containers-de-página)
2. [Summary Cards](#summary-cards)
3. [Tabelas](#tabelas)
4. [Empty States](#empty-states)
5. [Botões](#botões)
6. [Badges e Status](#badges-e-status)
7. [Modais](#modais)
8. [Cores Padrão](#cores-padrão)

---

## Containers de Página

### Container Principal
**Classe Padrão:**
```html
<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
```

**Componente Blade:**
```blade
<x-page-container title="Título da Página" :breadcrumb="['Menu', 'Submenu']">
    <!-- Conteúdo -->
</x-page-container>
```

### Container Interno
```html
<div class="container flex-grow mx-auto">
    <!-- Conteúdo -->
</div>
```

### Header de Página
```html
<div class="flex flex-col items-center justify-between my-4 sm:flex-row">
    <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">
        Título da Página
    </h3>
    <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
        <!-- Botões de ação -->
    </div>
</div>
```

---

## Summary Cards

### Padrão de Cards (4 cards por linha)
```html
<div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
    {{-- Card Exemplo --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[color]-500 to-[color]-600 rounded-lg shadow-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[color]-100">Título</p>
                    <p class="text-3xl font-bold text-white">{{ $valor }}</p>
                </div>
                <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                    <x-ui-icon name="icon-name" class="w-8 h-8 text-white" />
                </div>
            </div>
        </div>
    </div>
</div>
```

### Cores de Cards por Contexto
- **Total/Geral:** `from-blue-500 to-blue-600`
- **Ativo/Sucesso:** `from-green-500 to-green-600`
- **Inativo/Erro:** `from-red-500 to-red-600`
- **Especial/Destaque:** `from-purple-500 to-purple-600`
- **Informação:** `from-cyan-500 to-cyan-600`
- **Alerta:** `from-orange-500 to-orange-600`

### Componente Summary Card
```blade
<x-summary-card
    title="Total de Usuários"
    :value="number_format($stats->total, 0, ',', '.')"
    icon="user-group"
    color="blue"
/>
```

---

## Tabelas

### Container de Tabela
```html
<div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
    <x-tables.table>
        <x-slot name=header>
            <!-- Cabeçalhos -->
        </x-slot>
        <x-slot name=body>
            <!-- Linhas -->
        </x-slot>
    </x-tables.table>
</div>
```

### Background
- **Light Mode:** `bg-white`
- **Dark Mode:** `dark:bg-gray-800`
- **Shadow:** `shadow-md`
- **Border Radius:** `rounded-lg`

---

## Empty States

### Uso do Componente
```blade
@empty
    <x-empty-state
        colspan="7"
        icon="magnifying-glass"
        message="Nenhum registro encontrado"
        hint="Tente ajustar os filtros ou a busca"
    />
@endforelse
```

### Ícones por Contexto
- **Busca Geral:** `magnifying-glass`
- **Usuários:** `users`
- **Clientes:** `user-group`
- **Operadoras:** `building-office-2`
- **DIDs:** `hashtag` ou `phone`
- **CDRs:** `phone`
- **Faturas:** `document-text`
- **Relatórios:** `chart-bar`

---

## Botões

### Botão Primário (Ação Principal)
```html
<button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-all duration-200">
    Ação Principal
</button>
```

### Botão Secundário (Limpar/Cancelar)
```html
<button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
    <x-ui-icon name="x-mark" class="w-4 h-4 mr-2" />
    Limpar
</button>
```

### Botão de Filtro
```html
<button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
    <x-ui-icon name="adjustments-horizontal" class="w-4 h-4 mr-2" />
    Filtros
</button>
```

### Cor Primária do Sistema
**Padrão:** `purple-600` (roxo)
- Hover: `purple-700`
- Light: `purple-100`
- Dark text: `purple-800`

---

## Badges e Status

### Badge de Status Ativo
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
    <x-ui-icon name="check-circle" class="w-3 h-3 mr-1" />
    Ativo
</span>
```

### Badge de Status Inativo
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
    <x-ui-icon name="x-circle" class="w-3 h-3 mr-1" />
    Inativo
</span>
```

### Badge de Informação
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
    {{ $info }}
</span>
```

### Cores de Badges por Contexto
- **Sucesso/Ativo:** `bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200`
- **Erro/Inativo:** `bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200`
- **Aviso:** `bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200`
- **Informação:** `bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200`
- **Neutro:** `bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300`
- **Destaque:** `bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200`

---

## Modais

### Modal de Filtros
```blade
<x-ui-modal wire="filterModal" size="xl">
    <x-slot:title>
        <span class="text-xl font-bold">Filtros Avançados</span>
    </x-slot:title>

    <div class="space-y-4">
        <!-- Conteúdo do filtro -->
    </div>

    <x-slot:footer>
        <div class="flex justify-end gap-2">
            <x-ui-button color="stone" wire:click="$set('filterModal', false)">
                Fechar
            </x-ui-button>
            <x-ui-button color="red" wire:click="clearFilters">
                Limpar Filtros
            </x-ui-button>
        </div>
    </x-slot:footer>
</x-ui-modal>
```

---

## Cores Padrão

### Paleta Principal
```css
/* Cores Primárias */
--primary: purple-600      /* Roxo - Ação principal */
--success: green-600       /* Verde - Sucesso/Ativo */
--danger: red-600          /* Vermelho - Erro/Inativo */
--warning: yellow-600      /* Amarelo - Aviso */
--info: blue-600           /* Azul - Informação */

/* Backgrounds */
--bg-light: white
--bg-dark: gray-600
--bg-table-light: white
--bg-table-dark: gray-800
--bg-card-light: gray-50
--bg-card-dark: gray-700

/* Textos */
--text-primary-light: gray-800
--text-primary-dark: gray-200
--text-secondary-light: gray-600
--text-secondary-dark: gray-400

/* Borders */
--border-light: gray-300
--border-dark: gray-100
```

### Gradientes de Cards
```css
/* Padrão para Summary Cards */
bg-gradient-to-br from-{color}-500 to-{color}-600
```

---

## Notas Importantes

1. **Consistência:** Sempre use os componentes padrão (`<x-summary-card>`, `<x-empty-state>`, `<x-page-container>`)
2. **Dark Mode:** Todas as classes devem ter variante dark mode
3. **Responsividade:** Use classes `sm:`, `md:`, `lg:` para breakpoints
4. **Ícones:** Prefira `<x-ui-icon>` ao invés de SVGs inline
5. **Número de Formatação:** Use `number_format($value, 0, ',', '.')` para números inteiros
6. **Border Radius:**
   - Containers: `rounded-md`
   - Cards: `rounded-lg`
   - Badges: `rounded-full`
7. **Shadows:**
   - Containers: `shadow-md shadow-black/5`
   - Cards: `shadow-lg`
   - Tables: `shadow-md`
8. **Sidebar Routes:**
   - Use o nome exato da rota do Laravel (com ponto `.`)
   - Menus simples: `routename="dashboard.financial"` (compara com `==`)
   - Dropdowns: `routename="customers"` (compara com `Str::startsWith()`)
   - Sempre verifique com `php artisan route:list` o nome correto da rota

---

## Checklist de Padronização

- [ ] Container usa classe padrão ou componente `<x-page-container>`
- [ ] Summary cards seguem o padrão de 4 colunas com gradiente
- [ ] Tabela tem `rounded-lg` no container
- [ ] Empty state usa componente `<x-empty-state>`
- [ ] Botão primário usa `purple-600`
- [ ] Badges têm variante dark mode
- [ ] Todos os textos têm cores dark mode
- [ ] Ícones usam `<x-ui-icon>`
- [ ] Números formatados corretamente
- [ ] Modal de filtros segue estrutura padrão

---

*Documento criado em: {{ date('d/m/Y') }}*
*Última atualização: {{ date('d/m/Y H:i') }}*
