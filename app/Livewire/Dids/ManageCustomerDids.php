<?php

namespace App\Livewire\Dids;

use App\Models\Customer;
use App\Models\Did;
use App\Models\Carrier;
use Livewire\Attributes\Layout;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class ManageCustomerDids extends Component
{
    use Interactions;

    public $customerId;
    public $customer;
    public $dids = [];

    // Modal states
    public $modalCreate = false;
    public $modalUpdate = false;

    // Form properties
    public $editingDidId = null;
    public $did;
    public $carrier_id;
    public $descricao;
    public $valor_mensal;
    public $ativo = true;
    public $data_ativacao;
    public $quantidade = 1;
    public $proxy;
    public $porta;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->customer = Customer::findOrFail($customerId);
        $this->loadDids();
    }

    public function loadDids()
    {
        $this->dids = Did::where('customer_id', $this->customerId)
            ->with('carrier')
            ->orderBy('did')
            ->get();
    }

    public function openCreate()
    {
        $this->reset(['editingDidId', 'did', 'carrier_id', 'descricao', 'valor_mensal', 'data_ativacao', 'quantidade', 'proxy', 'porta']);
        $this->ativo = true;
        $this->quantidade = 1;
        $this->modalCreate = true;
    }

    public function create()
    {
        // Normalizar o DID (remover formatação)
        $didNormalizado = preg_replace('/\D/', '', $this->did);

        // Regras de validação dinâmicas baseadas no customer
        $rules = [
            'did' => 'required|string',
            'quantidade' => 'required|integer|min:1|max:30',
            'carrier_id' => 'required|exists:carriers,id',
            'descricao' => 'nullable|string|max:255',
            'valor_mensal' => 'nullable|numeric|min:0',
            'data_ativacao' => 'nullable|date',
        ];

        // Proxy e porta são obrigatórios se o customer não tiver configurações padrão
        if (!$this->customer->proxy_padrao) {
            $rules['proxy'] = 'required|string';
        } else {
            $rules['proxy'] = 'nullable|string';
        }

        if (!$this->customer->porta_padrao) {
            $rules['porta'] = 'required|integer|min:1|max:65535';
        } else {
            $rules['porta'] = 'nullable|integer|min:1|max:65535';
        }

        $this->validate($rules, [
            'did.required' => 'O número DID é obrigatório',
            'quantidade.required' => 'A quantidade é obrigatória',
            'quantidade.min' => 'A quantidade mínima é 1',
            'quantidade.max' => 'A quantidade máxima é 30',
            'carrier_id.required' => 'A operadora é obrigatória',
            'proxy.required' => 'O proxy é obrigatório quando o cliente não possui configuração padrão',
            'porta.required' => 'A porta é obrigatória quando o cliente não possui configuração padrão',
        ]);

        // Verificar se o DID tem 10 dígitos
        if (strlen($didNormalizado) != 10) {
            $this->addError('did', 'O número DID deve ter 10 dígitos');
            return;
        }

        try {
            $didBase = (int) $didNormalizado;

            // Verificar se algum dos DIDs já existe
            for ($i = 0; $i < $this->quantidade; $i++) {
                $didAtual = $didBase + $i;
                if (Did::where('did', $didAtual)->exists()) {
                    $this->toast()->error("DID {$didAtual} já existe!")->send();
                    return;
                }
            }

            // Criar os DIDs sequencialmente
            foreach (range(0, $this->quantidade - 1) as $i) {
                $didAtual = $didBase + $i;

                // Se proxy/porta estão vazios, usar os valores do cliente (para persistir no banco)
                $proxyFinal = $this->proxy ?: $this->customer->proxy_padrao;
                $portaFinal = $this->porta ?: $this->customer->porta_padrao;
                
                // Encaminhamento usa o proxy final
                $encaminhamento = $proxyFinal;

                Did::create([
                    'did' => $didAtual,
                    'customer_id' => $this->customerId,
                    'carrier_id' => $this->carrier_id,
                    'encaminhamento' => $encaminhamento,
                    'descricao' => $this->descricao,
                    'valor_mensal' => $this->valor_mensal,
                    'ativo' => $this->ativo,
                    'data_ativacao' => $this->data_ativacao,
                    'proxy' => $proxyFinal,
                    'porta' => $portaFinal,
                ]);
            }

            $this->modalCreate = false;
            $this->loadDids();

            $mensagem = $this->quantidade == 1
                ? 'DID adicionado com sucesso!'
                : "{$this->quantidade} DIDs adicionados com sucesso!";

            $this->toast()->success($mensagem)->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao criar DID(s): ' . $e->getMessage())->send();
        }
    }

    public function edit($id)
    {
        $did = Did::findOrFail($id);

        $this->editingDidId = $did->id;
        $this->did = $did->did;
        $this->carrier_id = $did->carrier_id;
        $this->descricao = $did->descricao;
        $this->valor_mensal = $did->valor_mensal;
        $this->ativo = $did->ativo;
        $this->data_ativacao = $did->data_ativacao?->format('Y-m-d');
        $this->proxy = $did->proxy;
        $this->porta = $did->porta;

        $this->modalUpdate = true;
    }

    public function update()
    {
        // Regras de validação dinâmicas baseadas no customer
        $rules = [
            'did' => 'required|digits:10|unique:dids,did,' . $this->editingDidId,
            'carrier_id' => 'required|exists:carriers,id',
            'descricao' => 'nullable|string|max:255',
            'valor_mensal' => 'nullable|numeric|min:0',
            'data_ativacao' => 'nullable|date',
        ];

        // Proxy e porta são obrigatórios se o customer não tiver configurações padrão
        if (!$this->customer->proxy_padrao) {
            $rules['proxy'] = 'required|string';
        } else {
            $rules['proxy'] = 'nullable|string';
        }

        if (!$this->customer->porta_padrao) {
            $rules['porta'] = 'required|integer|min:1|max:65535';
        } else {
            $rules['porta'] = 'nullable|integer|min:1|max:65535';
        }

        $this->validate($rules, [
            'proxy.required' => 'O proxy é obrigatório quando o cliente não possui configuração padrão',
            'porta.required' => 'A porta é obrigatória quando o cliente não possui configuração padrão',
        ]);

        // Se proxy/porta estão vazios, usar os valores do cliente (para persistir no banco)
        $proxyFinal = $this->proxy ?: $this->customer->proxy_padrao;
        $portaFinal = $this->porta ?: $this->customer->porta_padrao;
        
        // Encaminhamento usa o proxy final
        $encaminhamento = $proxyFinal;

        $did = Did::findOrFail($this->editingDidId);
        $did->update([
            'did' => $this->did,
            'carrier_id' => $this->carrier_id,
            'encaminhamento' => $encaminhamento,
            'descricao' => $this->descricao,
            'valor_mensal' => $this->valor_mensal,
            'ativo' => $this->ativo,
            'data_ativacao' => $this->data_ativacao,
            'proxy' => $proxyFinal,
            'porta' => $portaFinal,
        ]);

        $this->modalUpdate = false;
        $this->loadDids();
        $this->toast()->success('DID atualizado com sucesso!')->send();
    }

    public function toggleAtivo($id)
    {
        $did = Did::findOrFail($id);
        $did->ativo = !$did->ativo;
        $did->save();

        $this->loadDids();
        $status = $did->ativo ? 'ativado' : 'desativado';
        $this->toast()->success("DID {$status} com sucesso!")->send();
    }

    public function delete($id)
    {
        Did::findOrFail($id)->delete();
        $this->loadDids();
        $this->toast()->success('DID removido com sucesso!')->send();
    }

    public function getCarriers()
    {
        return Carrier::where('ativo', true)->get();
    }

    public function render()
    {
        return view('livewire.dids.manage-customer-dids', [
            'carriers' => $this->getCarriers(),
        ]);
    }
}
