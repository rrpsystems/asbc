<?php

namespace App\Livewire\Cdrs;

use App\Enums\TipoTarifa;
use App\Livewire\Traits\Table;
use App\Models\Carrier;
use App\Models\Cdr;
use App\Models\Customer;
use App\Models\Did;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $data_inicial;

    public $data_final;

    public $tarifas;

    public $tarifa = [];

    public $dids;

    public $did = [];

    public $carriers; // Para armazenar a lista de carriers

    public $carrier = []; // ID da carrier selecionada

    public $customers; // Para armazenar a lista de carriers

    public $customer = []; // ID da carrier selecionada

    public $status; // ID da carrier selecionada

    public $stat = []; // ID da carrier selecionada

    public $desligamentos; // ID da carrier selecionada

    public $desligamento = []; // ID da carrier selecionada

    public $numero;

    public $ramal;

    public $slide = false;

    use Table;

    public function mount()
    {
	$this->direction = 'DESC';
        $this->status = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Pendente', 'value' => 'Pendente'],
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

    public function updatedStat($value)
    {
        if (! is_array($this->stat)) {
            $this->stat = [];
        }
        if (in_array('All', $this->stat)) {
            // Se "Todos" for selecionado, substitui por todas as operadoras
            $this->stat = ['Pendente', 'Tarifado', 'Erro'];
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
                'label' => $customer->razaosocial,
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
        $this->stat = ['Pendente', 'Tarifado', 'Erro'];
    }

    public function render()
    {
        $cdrs = Cdr::Where('id', 'like', '%'.$this->search.'%')//with('carrier', 'customer')
//            ->whereBetween('calldate', [$this->data_inicial, $this->data_final])
  //          ->whereIn('carrier_id', $this->carrier)
    //        ->whereIn('customer_id', $this->customer)
      //      ->whereIn('did_id', $this->did)
        //    ->whereIn('tarifa', $this->tarifa)
          //  ->whereIn('desligamento', $this->desligamento)
            //->whereIn('status', $this->stat)
//            ->when($this->ramal, function ($query) {
  //              $query->where('ramal', 'like', '%'.$this->ramal.'%');
    //        })
      //      ->when($this->numero, function ($query) {
        //        $query->where('numero', 'like', '%'.$this->numero.'%');
          //  })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.cdrs.index', compact('cdrs'));
    }
}
