<?php

namespace App\Livewire\Cdrs;

use App\Enums\TipoTarifa;
use App\Livewire\Traits\Table;
use App\Models\Carrier;
use App\Models\Cdr;
use App\Models\Customer;
use App\Models\Did;
//use App\Services\CallTariffService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $data_inicial;

    public $data_final;

    public $tarifas;

    public $dids;

    public $carriers;

    public $customers;

    public $status;

    public $desligamentos;

    public $numero;

    public $ramal;

    public $filters = [];

    public $tarifa = [];

    public $did = [];

    public $carrier = []; // ID da carrier selecionada

    public $customer = []; // ID da carrier selecionada

    public $stat = []; // ID da carrier selecionada

    public $desligamento = []; // ID da carrier selecionada

    public $details;

    public $slide = false;

    public $modal = false;

    use Table;

    //public $cdr; // Certifique-se de que isso esteja definido corretamente

    //protected $tariffService;

    // public function mount(CallTariffService $tariffService)
    public function mount()
    {
        //$this->cdr = Cdr::where('status', 'Pendente')->where('billsec', '<', 40)->where('billsec', '>', 3)->where('tarifa', 'Fixo')->first();
        //$this->tariffService = $tariffService;
        //$tarifas = $this->tariffService->calcularTarifa($this->cdr);
        //dd($tarifas, $this->cdr); // ou armazene em uma variável para exibir na view

        // $this->tariffService->calcularTarifa($this->cdr);

        $this->direction = 'DESC';

        $this->status = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Pendente', 'value' => 'Pendente'],
            ['label' => 'Processada', 'value' => 'Processada'],
            ['label' => 'Tarifado', 'value' => 'Tarifado'],
            ['label' => 'Erro', 'value' => 'Erro'],
        ];
        $this->desligamentos = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Origem', 'value' => 'Origem'],
            ['label' => 'Destino', 'value' => 'Destino'],
        ];

        $this->resetFilter();
    }

    public function openDetails($value)
    {
        $this->details = Cdr::find($value);
        // dd($this->details);
        $this->modal = true;

    }

    public function updatedStat($value)
    {
        if (! is_array($this->stat)) {
            $this->stat = [];
        }
        if (in_array('All', $this->stat)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->stat = ['Pendente', 'Tarifado', 'Erro', 'Processada'];
        }
    }

    public function updatedDesligamento($value)
    {
        //dd($value);
        if (! is_array($this->desligamento)) {
            $this->desligamento = [];
        }
        if (in_array('All', $this->desligamento)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->desligamento = ['Origem', 'Destino'];
        }
    }

    public function updatedCarrier($value)
    {

        if (! is_array($this->carrier)) {
            $this->carrier = [];
        }
        if (in_array('All', $this->carrier)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->carrier = Carrier::pluck('id')->toArray();
        }
    }

    public function updatedDid($value)
    {
        if (! is_array($this->did)) {
            $this->did = [];
        }
        if (in_array('All', $this->did)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->did = Did::pluck('did')->toArray();
        }
    }

    public function updatedCustomer($value)
    {
        if (! is_array($this->customer)) {
            $this->customer = [];
        }
        if (in_array('All', $this->customer)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->customer = Customer::pluck('id')->toArray();
        }
    }

    public function updatedTarifa($value)
    {
        // Garante que $this->tarifa seja sempre um array
        if (! is_array($this->tarifa)) {
            $this->tarifa = [];
        }
        if (in_array('All', $this->tarifa)) {
            // Se "Todos" for selecionado, substitui por todos os valores possíveis
            $this->tarifa = collect(\App\Enums\TipoTarifa::options())
                ->pluck('value')->toArray();
        }
    }

    public function openFilter()
    {
        $this->slide = true;
    }

    public function filter()
    {
        $this->filters['data_inicial'] = $this->data_inicial.'T00:00:00';
        $this->filters['data_final'] = $this->data_final.'T23:59:59';
        $this->filters['tarifa'] = $this->tarifa;
        $this->filters['did'] = $this->did;
        $this->filters['carrier'] = $this->carrier;
        $this->filters['customer'] = $this->customer;
        $this->filters['stat'] = $this->stat;
        $this->filters['desligamento'] = $this->desligamento;
        $this->filters['numero'] = $this->numero;
        $this->filters['ramal'] = $this->ramal;

        $this->slide = false;
    }

    public function cancel()
    {

        $this->slide = false;
    }

    public function resetFilter()
    {

        $this->data_inicial = Carbon::now()->firstOfMonth()->toDateString();
        $this->data_final = Carbon::now()->toDateString();

        $this->tarifas = TipoTarifa::optionsWithAll();
        $this->tarifa = collect(TipoTarifa::options())
            ->pluck('value')->toArray();

        $this->carrier = Carrier::pluck('id')->toArray();
        $this->carriers = collect([
            [
                'label' => 'Todos',  // Rótulo para "Todos"
                'value' => 'All',    // Valor especial para representar todos
                'description' => 'Selecionar todas as operadoras',
            ],
        ])->merge(Carrier::all()->map(function ($carrier) {
            return [
                'label' => $carrier->operadora,
                'value' => $carrier->id,
                'description' => $carrier->id,
            ];
        }))->toArray();

        $this->customer = Customer::pluck('id')->toArray();
        $this->customers = collect([
            [
                'label' => 'Todos',  // Rótulo para "Todos"
                'value' => 'All',    // Valor especial para representar todos
                'description' => 'Selecionar todos os clientes',
            ],
        ])->merge(Customer::all()->map(function ($customer) {
            return [
                'label' => Str::limit($customer->razaosocial, 15),
                'value' => $customer->id,
                'description' => $customer->id,
            ];
        }))->toArray();

        $this->did = Did::pluck('did')->toArray();
        $this->dids = collect([
            [
                'label' => 'Todos',  // Rótulo para "Todos"
                'value' => 'All',    // Valor especial para representar todos
                'description' => 'Selecionar todos os dids',
            ],
        ])->merge(Did::with('customer')->get()->map(function ($did) {
            return [
                'label' => $did->did,
                'value' => $did->did,
                'description' => $did->customer->razaosocial ?? 'Sem Cliente', // Prevenir erro se 'customer' for null
            ];
        }))->toArray();
        $this->desligamento = ['Origem', 'Destino'];
        $this->stat = ['Pendente', 'Tarifado', 'Processada', 'Erro'];

        $this->filters['data_inicial'] = $this->data_inicial.'T00:00:00';
        $this->filters['data_final'] = $this->data_final.'T23:59:59';
        $this->filters['tarifa'] = $this->tarifa;
        $this->filters['did'] = $this->did;
        $this->filters['carrier'] = $this->carrier;
        $this->filters['customer'] = $this->customer;
        $this->filters['stat'] = $this->stat;
        $this->filters['desligamento'] = $this->desligamento;
        $this->filters['numero'] = $this->numero;
        $this->filters['ramal'] = $this->ramal;
    }

    public function render()
    {
        // dd($this->data_inicial, $this->data_final);
        //$cdrs = Cdr::Where('id', 'like', '%'.$this->search.'%')//with('carrier', 'customer')
        $cdrs = Cdr::with('customer', 'carrier')
            ->whereBetween('calldate', [$this->filters['data_inicial'], $this->filters['data_final']])
            ->whereIn('carrier_id', $this->filters['carrier'])
            ->whereIn('customer_id', $this->filters['customer'])
            ->whereIn('did_id', $this->filters['did'])
            ->whereIn('tarifa', $this->filters['tarifa'])
            ->whereIn('desligamento', $this->filters['desligamento'])
            ->whereIn('status', $this->filters['stat'])
            ->when($this->filters['ramal'], function ($query) {
                $query->where('ramal', 'like', '%'.$this->filters['ramal'].'%');
            })
            ->when($this->filters['numero'], function ($query) {
                $query->where('numero', 'like', '%'.$this->filters['numero'].'%');
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.cdrs.index', compact('cdrs'));
    }
}
