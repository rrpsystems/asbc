<?php

namespace App\Livewire\Dids;

use App\Models\Carrier;
use App\Models\Customer;
use App\Models\Did;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $carriers; // Para armazenar a lista de carriers

    public $carrier_id; // ID da carrier selecionada

    public $customers; // Para armazenar a lista de carriers

    public $customer_id; // ID da carrier selecionada

    public $quantidade = 1;

    public $encaminhamento = 'RRPBX01';

    public $ipvoip = '@144.22.234.219:5080';

    public $did;

    public $ativo = true;

    public $slide = false;

    private $msg_error = 'Erro ao criar o(s) Numero(s)!';

    private $msg_success = 'Numero criado com sucesso!';

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

    public function updatedDid($value)
    {
        $this->did = preg_replace(
            '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
            '($1$4) $2$5-$3$6',
            $value
        );
    }

    public function store()
    {
        $this->resetValidation();
        $this->normalizeData();
        $this->validate([
            'quantidade' => 'required|numeric|min:1|max:30',
            'did' => 'required|digits:10|unique:dids',
            'customer_id' => 'required',
            'carrier_id' => 'required',
            'encaminhamento' => 'required|string|min:3',
        ]);

        try {
            foreach (range(1, $this->quantidade) as $i) {
                Did::create([
                    'did' => $this->did++,
                    'customer_id' => $this->customer_id,
                    'carrier_id' => $this->carrier_id,
                    'encaminhamento' => $this->encaminhamento,
                    'ativo' => $this->ativo,
                ]);
            }

        } catch (\Exception $e) {
            Log::error($this->msg_error.' Erro: '.$e->getMessage()); // Registra o erro
            $this->slide = false;
            $this->toast()->error($this->msg_error)->send();
            $this->dispatch('table-update');

            return;
        }
        $this->cancel();
        $this->toast()->success($this->msg_success)->send();

    }

    protected function apresentationData()
    {
        $this->did = preg_replace(
            '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
            '($1$4) $2$5-$3$6',
            $this->did
        );
    }

    protected function normalizeData()
    {
        $this->did = preg_replace('/\D/', '', $this->did);
    }

    #[On('did-create')]
    public function create()
    {
        $this->slide = true;
    }

    public function cancel()
    {
        $this->dispatch('table-update');
        $this->resetValidation();
        $this->reset(['did', 'carrier_id', 'customer_id', 'encaminhamento', 'quantidade',  'ativo']);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.dids.create');
    }
}
