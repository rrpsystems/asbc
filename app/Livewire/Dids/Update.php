<?php

namespace App\Livewire\Dids;

use App\Models\Carrier;
use App\Models\Customer;
use App\Models\Did;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;
    use Interactions;

    public $carriers; // Para armazenar a lista de carriers

    public $carrier_id; // ID da carrier selecionada

    public $customers; // Para armazenar a lista de carriers

    public $customer_id; // ID da carrier selecionada

    public $quantidade = 1;

    public $encaminhamento;

    public $did;

    public $editDid;

    public $ativo = true;

    public $slide = false;

    public $proxy;

    public $porta;

    public $ipvoip = '@144.22.234.219:5080';

    private $msg_error = 'Erro ao alterar o Numero! ';

    private $msg_success = 'Numero alterado com sucesso!';

    protected function apresentationData()
    {
        $this->did = preg_replace(
            '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
            '($1$4) $2$5-$3$6',
            $this->did
        );
    }

    public function updatedDid($value)
    {
        $this->did = preg_replace(
            '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
            '($1$4) $2$5-$3$6',
            $value
        );
    }

    protected function normalizeData()
    {
        $this->did = preg_replace('/\D/', '', $this->did);
    }

    public function mount()
    {
        $this->carriers = Carrier::all()->map(function ($carrier) {
            return [
                'label' => $carrier->operadora,
                'value' => $carrier->id,
                'description' => $carrier->id,
            ];
        })->toArray();

        $this->customers = Customer::all()->map(function ($customer) {
            return [
                'label' => $customer->razaosocial,
                'value' => $customer->id,
                'description' => $customer->id,
            ];
        })->toArray();
    }

    #[On('did-update')]
    public function edit($id)
    {

        //dd($this->tarifas);
        $this->editDid = Did::find($id);
        $this->did = $this->editDid->did;
        $this->customer_id = $this->editDid->customer_id;
        $this->carrier_id = $this->editDid->carrier_id;
        $this->encaminhamento = $this->editDid->encaminhamento;
        $this->ativo = $this->editDid->ativo;
        $this->proxy = $this->editDid->proxy;
        $this->porta = $this->editDid->porta;
        $this->apresentationData();
        $this->slide = true;
    }

    public function update()
    {
        $this->resetValidation();
        $this->normalizeData();
        $this->validate([
            'quantidade' => 'required|numeric|min:1|max:30',
            'did' => 'required|digits:10|unique:dids,did,'.$this->editDid->id,
            'customer_id' => 'required',
            'carrier_id' => 'required',
            'encaminhamento' => 'required|string|min:3',
        ]);

        $data = [
            'did' => $this->did,
            'customer_id' => $this->customer_id,
            'carrier_id' => $this->carrier_id,
            'encaminhamento' => $this->encaminhamento,
            'ativo' => $this->ativo,
            'proxy' => $this->proxy,
            'porta' => $this->porta,
        ];

        try {
            $this->editDid->update($data);
        } catch (\Exception $e) {
            Log::error($this->msg_error.' Erro: '.$e->getMessage()); // Registra o erro
            $this->dispatch('table-update');
            $this->toast()->error($this->msg_error)->send();

            return;
        }

        $this->cancel();
        $this->toast()->success($this->msg_success)->send();
    }

    public function cancel()
    {
        $this->dispatch('table-update');
        $this->resetValidation();
        $this->reset(['did', 'carrier_id', 'customer_id', 'encaminhamento', 'quantidade', 'ativo',
            'proxy', 'porta']);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.dids.update');
    }
}
