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

    public $filterModal = false;

    public $detailsModal = false;

    use Table;

    /**
     * Exporta CDRs filtrados para Excel
     */
    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CdrsExport($this->filters),
            'cdrs_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Exporta CDRs filtrados para CSV
     */
    public function exportCsv()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CdrsExport($this->filters),
            'cdrs_' . date('Y-m-d_His') . '.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

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
            ['label' => 'Tarifada', 'value' => 'Tarifada'],
            ['label' => 'Erro', 'value' => 'Erro'],
            ['label' => 'Erro Tarifa', 'value' => 'Erro_Tarifa'],
            ['label' => 'Tarifa Não Encontrada', 'value' => 'Tarifa_Nao_Encontrada'],
            ['label' => 'Dados Inválidos', 'value' => 'Dados_Invalidos'],
            ['label' => 'Erro Permanente', 'value' => 'Erro_Permanente'],
        ];
        $this->desligamentos = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Origem', 'value' => 'Origem'],
            ['label' => 'Destino', 'value' => 'Destino'],
        ];

        // Aplica filtros da URL se existirem (vindo da página de manutenção)
        $hasUrlFilters = request()->has('stat');

        // Se veio da URL com filtros específicos, configura apenas esses filtros
        if ($hasUrlFilters) {
            $statFromUrl = request()->get('stat');

            if (is_array($statFromUrl) && !empty($statFromUrl)) {
                // Define apenas filtros essenciais, sem processar "All" que exclui registros órfãos
                // Busca data do CDR mais antigo no banco para garantir que pegue todos
                $oldestCdr = Cdr::orderBy('calldate', 'asc')->first();
                $this->data_inicial = $oldestCdr ? Carbon::parse($oldestCdr->calldate)->toDateString() : Carbon::now()->subYears(2)->toDateString();
                $this->data_final = Carbon::now()->toDateString();
                $this->stat = $statFromUrl;

                // NÃO chama resetFilter() que processaria "All" e excluiria registros com IDs órfãos
                // Aplica filtros manualmente apenas para os campos necessários
                $this->filters = [
                    'data_inicial' => $this->data_inicial . 'T00:00:00',
                    'data_final' => $this->data_final . 'T23:59:59',
                    'stat' => $statFromUrl,
                    // Deixa outros filtros vazios para não excluir registros órfãos
                    'tarifa' => [],
                    'carrier' => [],
                    'customer' => [],
                    'did' => [],
                    'desligamento' => [],
                    'numero' => '',
                    'ramal' => '',
                ];

                // Carrega opções dos selects para exibição
                $this->tarifas = TipoTarifa::optionsWithAll();
                $this->tarifa = [];

                $this->carriers = collect([
                    ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todas as operadoras'],
                ])->merge(
                    Carrier::select('id', 'operadora')->get()->map(function ($carrier) {
                        return [
                            'label' => $carrier->operadora,
                            'value' => $carrier->id,
                            'description' => Str::limit($carrier->operadora, 20),
                        ];
                    })
                )->toArray();
                $this->carrier = [];

                $this->customers = collect([
                    ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todos os clientes'],
                ])->merge(
                    Customer::select('id', 'razaosocial', 'nomefantasia')
                        ->get()
                        ->map(function ($customer) {
                            return [
                                'label' => $customer->razaosocial,
                                'value' => $customer->id,
                                'description' => Str::limit($customer->nomefantasia ?? $customer->razaosocial, 20),
                            ];
                        })
                )->toArray();
                $this->customer = [];

                $this->dids = collect([
                    ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todos os DIDs'],
                ])->merge(
                    Did::select('id', 'did', 'customer_id')
                        ->with('customer:id,razaosocial')
                        ->get()
                        ->map(function ($did) {
                            return [
                                'label' => $did->did,
                                'value' => $did->id,
                                'description' => Str::limit($did->customer->razaosocial ?? 'Sem Cliente', 20),
                            ];
                        })
                )->toArray();
                $this->did = [];

                $this->desligamento = [];
                $this->numero = '';
                $this->ramal = '';
            }
        } else {
            // Fluxo normal sem filtros da URL
            $this->resetFilter(); // resetFilter() já chama filter() internamente
        }
    }

    public function openDetails($value)
    {
        $this->details = Cdr::find($value);
        // dd($this->details);
        $this->detailsModal = true;

    }

    // Removidos os métodos updatedXXX que causavam lentidão
    // Validação de "Todos" agora será feita no método filter()

    public function openFilter()
    {
        $this->filterModal = true;
    }

    public function filter()
    {
        // Processar "Todos" apenas quando aplicar filtros
        $tarifa = $this->tarifa;
        if (is_array($tarifa) && in_array('All', $tarifa)) {
            $tarifa = collect(TipoTarifa::options())->pluck('value')->toArray();
        }

        $carrier = $this->carrier;
        if (is_array($carrier) && in_array('All', $carrier)) {
            $carrier = Carrier::pluck('id')->toArray();
        }

        $customer = $this->customer;
        if (is_array($customer) && in_array('All', $customer)) {
            $customer = Customer::pluck('id')->toArray();
        }

        $did = $this->did;
        if (is_array($did) && in_array('All', $did)) {
            $did = Did::pluck('did')->toArray();
        }

        $stat = $this->stat;
        if (is_array($stat) && in_array('All', $stat)) {
            $stat = ['Pendente', 'Tarifada', 'Erro', 'Processada'];
        }

        $desligamento = $this->desligamento;
        if (is_array($desligamento) && in_array('All', $desligamento)) {
            $desligamento = ['Origem', 'Destino'];
        }

        // Aplicar filtros
        $this->filters['data_inicial'] = $this->data_inicial . 'T00:00:00';
        $this->filters['data_final'] = $this->data_final . 'T23:59:59';
        $this->filters['tarifa'] = $tarifa;
        $this->filters['did'] = $did;
        $this->filters['carrier'] = $carrier;
        $this->filters['customer'] = $customer;
        $this->filters['stat'] = $stat;
        $this->filters['desligamento'] = $desligamento;
        $this->filters['numero'] = $this->numero;
        $this->filters['ramal'] = $this->ramal;

        $this->resetPage(); // Reset pagination quando filtrar
        $this->filterModal = false;
    }

    public function closeFilterModal()
    {
        $this->filterModal = false;
    }

    public function resetFilter()
    {
        $this->data_inicial = Carbon::now()->firstOfMonth()->toDateString();
        $this->data_final = Carbon::now()->toDateString();

        // Tarifas
        $this->tarifas = TipoTarifa::optionsWithAll();
        $this->tarifa = ['All']; // Seleciona "Todos" por padrão

        // Carriers - carrega apenas para o select
        $this->carrier = ['All'];
        $this->carriers = collect([
            ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todas as operadoras'],
        ])->merge(
                Carrier::select('id', 'operadora')->get()->map(function ($carrier) {
                    return [
                        'label' => $carrier->operadora,
                        'value' => $carrier->id,
                        'description' => $carrier->id,
                    ];
                })
            )->toArray();

        // Customers - carrega apenas para o select
        $this->customer = ['All'];
        $this->customers = collect([
            ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todos os clientes'],
        ])->merge(
                Customer::select('id', 'razaosocial')->where('ativo', true)->get()->map(function ($customer) {
                    return [
                        'label' => Str::limit($customer->razaosocial, 30),
                        'value' => $customer->id,
                        'description' => $customer->id,
                    ];
                })
            )->toArray();

        // DIDs - carrega apenas para o select (limitado para performance)
        $this->did = ['All'];
        $this->dids = collect([
            ['label' => 'Todos', 'value' => 'All', 'description' => 'Selecionar todos os DIDs'],
        ])->merge(
                Did::select('did', 'customer_id')
                    ->with('customer:id,razaosocial')
                    ->limit(1000) // Limita para evitar lentidão
                    ->get()
                    ->map(function ($did) {
                        return [
                            'label' => $did->did,
                            'value' => $did->id,
                            'description' => Str::limit($did->customer->razaosocial ?? 'Sem Cliente', 20),
                        ];
                    })
            )->toArray();

        $this->desligamento = ['All'];
        $this->stat = ['All'];
        $this->numero = '';
        $this->ramal = '';

        // Aplicar filtros padrão (será processado ao chamar filter())
        $this->filter();
    }

    public function render()
    {
        $query = Cdr::query()
            ->select([
                'cdrs.*', // Seleciona apenas campos necessários
            ])
            ->with([
                'customer:id,razaosocial,nomefantasia', // Eager load otimizado
                'carrier:id,operadora'
            ])
            ->whereBetween('calldate', [$this->filters['data_inicial'], $this->filters['data_final']])
            ->when(!empty($this->filters['carrier']), function ($query) {
                $query->whereIn('carrier_id', $this->filters['carrier']);
            })
            ->when(!empty($this->filters['customer']), function ($query) {
                $query->whereIn('customer_id', $this->filters['customer']);
            })
            ->when(!empty($this->filters['did']), function ($query) {
                $query->whereIn('did_id', $this->filters['did']);
            })
            ->when(!empty($this->filters['tarifa']), function ($query) {
                $query->whereIn('tarifa', $this->filters['tarifa']);
            })
            ->when(!empty($this->filters['desligamento']), function ($query) {
                $query->whereIn('desligamento', $this->filters['desligamento']);
            })
            ->when(!empty($this->filters['stat']), function ($query) {
                // Mapeia valores com espaços para valores com underscores (compatibilidade)
                $statusValues = collect($this->filters['stat'])->map(function($status) {
                    $mapping = [
                        'Erro Tarifa' => 'Erro_Tarifa',
                        'Tarifa Não Encontrada' => 'Tarifa_Nao_Encontrada',
                        'Dados Inválidos' => 'Dados_Invalidos',
                        'Erro Permanente' => 'Erro_Permanente',
                    ];
                    return $mapping[$status] ?? $status;
                })->toArray();

                $query->whereIn('status', $statusValues);
            })
            ->when($this->filters['ramal'] ?? false, function ($query) {
                $query->where('ramal', 'like', '%' . $this->filters['ramal'] . '%');
            })
            ->when($this->filters['numero'] ?? false, function ($query) {
                $query->where('numero', 'like', '%' . $this->filters['numero'] . '%');
            })
            ->orderBy($this->sort, $this->direction);

        $cdrs = $query->paginate($this->perPage);

        return view('livewire.cdrs.index', compact('cdrs'));
    }
}
