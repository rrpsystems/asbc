<?php

namespace App\Livewire\Customers\Products;

use App\Enums\TipoProduto;
use App\Models\Customer;
use App\Models\CustomerProduct;
use Livewire\Attributes\Layout;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class Index extends Component
{
    use Interactions;

    public $customerId;
    public $customer;
    public $produtos = [];

    // Modal states
    public $modalCreate = false;
    public $modalUpdate = false;

    // Form properties
    public $productId;
    public $tipo_produto;
    public $descricao;
    public $quantidade = 1;
    public $valor_custo_unitario = 0;
    public $valor_venda_unitario = 0;
    public $ativo = true;
    public $data_ativacao;

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->customer = Customer::findOrFail($customerId);
        $this->loadProdutos();
    }

    public function loadProdutos()
    {
        $this->produtos = CustomerProduct::where('customer_id', $this->customerId)
            ->orderBy('ativo', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openCreate()
    {
        $this->reset(['tipo_produto', 'descricao', 'quantidade', 'valor_custo_unitario', 'valor_venda_unitario', 'ativo', 'data_ativacao']);
        $this->quantidade = 1;
        $this->ativo = true;
        $this->data_ativacao = now()->format('Y-m-d');
        $this->modalCreate = true;
    }

    public function create()
    {
        $this->validate([
            'tipo_produto' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_custo_unitario' => 'required|numeric|min:0',
            'valor_venda_unitario' => 'required|numeric|min:0',
        ], [
            'tipo_produto.required' => 'Selecione o tipo de produto',
            'quantidade.required' => 'Informe a quantidade',
            'quantidade.min' => 'Quantidade mínima é 1',
            'valor_custo_unitario.required' => 'Informe o valor de custo',
            'valor_venda_unitario.required' => 'Informe o valor de venda',
        ]);

        try {
            $product = CustomerProduct::create([
                'customer_id' => $this->customerId,
                'tipo_produto' => $this->tipo_produto,
                'descricao' => $this->descricao,
                'quantidade' => $this->quantidade,
                'valor_custo_unitario' => $this->valor_custo_unitario,
                'valor_venda_unitario' => $this->valor_venda_unitario,
                'ativo' => $this->ativo,
                'data_ativacao' => $this->data_ativacao,
            ]);

            \Illuminate\Support\Facades\Log::info('Produto criado com sucesso', [
                'product_id' => $product->id,
                'customer_id' => $this->customerId,
                'tipo_produto' => $this->tipo_produto,
            ]);

            $this->toast()->success('Produto adicionado com sucesso!')->send();
            $this->modalCreate = false;
            $this->loadProdutos();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao criar produto', [
                'customer_id' => $this->customerId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->toast()->error('Erro ao adicionar produto: ' . $e->getMessage())->send();
        }
    }

    public function edit($id)
    {
        $product = CustomerProduct::findOrFail($id);

        $this->productId = $product->id;
        $this->tipo_produto = $product->tipo_produto->value;
        $this->descricao = $product->descricao;
        $this->quantidade = $product->quantidade;
        $this->valor_custo_unitario = $product->valor_custo_unitario;
        $this->valor_venda_unitario = $product->valor_venda_unitario;
        $this->ativo = $product->ativo;
        $this->data_ativacao = $product->data_ativacao?->format('Y-m-d');

        $this->modalUpdate = true;
    }

    public function update()
    {
        $this->validate([
            'tipo_produto' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_custo_unitario' => 'required|numeric|min:0',
            'valor_venda_unitario' => 'required|numeric|min:0',
        ]);

        $product = CustomerProduct::findOrFail($this->productId);
        $product->update([
            'tipo_produto' => $this->tipo_produto,
            'descricao' => $this->descricao,
            'quantidade' => $this->quantidade,
            'valor_custo_unitario' => $this->valor_custo_unitario,
            'valor_venda_unitario' => $this->valor_venda_unitario,
            'ativo' => $this->ativo,
            'data_ativacao' => $this->data_ativacao,
        ]);

        $this->toast()->success('Produto atualizado com sucesso!')->send();
        $this->modalUpdate = false;
        $this->loadProdutos();
    }

    public function delete($id)
    {
        $product = CustomerProduct::findOrFail($id);
        $product->delete();

        $this->toast()->success('Produto removido com sucesso!')->send();
        $this->loadProdutos();
    }

    public function toggleAtivo($id)
    {
        $product = CustomerProduct::findOrFail($id);
        $product->update([
            'ativo' => !$product->ativo,
            'data_cancelamento' => !$product->ativo ? now() : null,
        ]);

        $this->toast()->success($product->ativo ? 'Produto ativado!' : 'Produto desativado!')->send();
        $this->loadProdutos();
    }

    public function getTiposProduto()
    {
        return collect(TipoProduto::cases())->map(function($tipo) {
            return [
                'value' => $tipo->value,
                'label' => $tipo->label(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.customers.products.index', [
            'tiposProduto' => $this->getTiposProduto(),
        ]);
    }
}
