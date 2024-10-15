<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;

    public $customer;

    //public $user;
    public $cnpj;

    public $vencimento = 10;

    public $contrato;

    public $old_contrato;

    public $razaosocial;

    public $nomefantasia;

    public $endereco;

    public $numero;

    public $complemento;

    public $cidade;

    public $uf;

    public $cep;

    public $canais = 3;

    public $valor_plano = 100.00;

    public $franquia_minutos = 1000;

    public $valor_excedente = 0;

    public $data_inicio;

    public $data_fim;

    public $email;

    public $telefone;

    public $password = 'cliente';

    public $ativo = true;

    public $slide = false;

    #[On('customer-update')]
    public function edit($id)
    {

        //dd($this->tarifas);

        $this->customer = Customer::find($id);

        $this->contrato = $this->customer->id;
        $this->old_contrato = $this->customer->id;
        $this->cnpj = $this->customer->cnpj;
        $this->razaosocial = $this->customer->razaosocial;
        $this->endereco = $this->customer->endereco;
        $this->numero = $this->customer->numero;
        $this->complemento = $this->customer->complemento;
        $this->cidade = $this->customer->cidade;
        $this->uf = $this->customer->uf;
        $this->cep = $this->customer->cep;
        $this->vencimento = $this->customer->vencimento;
        $this->canais = $this->customer->canais;
        $this->valor_plano = $this->customer->valor_plano;
        $this->franquia_minutos = $this->customer->franquia_minutos;
        $this->valor_excedente = $this->customer->valor_excedente;
        $this->data_inicio = $this->customer->data_inicio;
        $this->data_fim = $this->customer->data_fim;
        $this->email = $this->customer->email;
        $this->telefone = $this->customer->telefone;
        $this->ativo = $this->customer->ativo;
        $this->slide = true;
        $this->apresentationData();

    }

    public function update()
    {
        $this->normalizeData();
        $this->validate([
            'contrato' => 'required|digits_between:4,10|unique:customers,id,'.$this->old_contrato,
            'cnpj' => 'required|digits:14',
            'razaosocial' => 'required|string|min:3',
            'endereco' => 'required|string|min:3',
            'numero' => 'required',
            'cep' => 'required|digits:8',
            'cidade' => 'required|string|min:5',
            'uf' => 'required|string|min:2|max:2',
            'franquia_minutos' => 'required|numeric|min:100|max:1000000',
            'valor_plano' => 'required|numeric|min:10.00|max:100000.00',
            'password' => 'required|string|min:6',
            'canais' => 'required|numeric|min:1|max:30',
            'vencimento' => 'required|numeric|min:1|max:30',
            'data_inicio' => 'required|date',
        ]);

        try {
            DB::beginTransaction(); // Inicia a transação

            // Criação do Customer
            $this->customer->update([
                'id' => $this->contrato,
                'cnpj' => $this->cnpj,
                'razaosocial' => $this->razaosocial,
                'endereco' => $this->endereco,
                'numero' => $this->numero,
                'complemento' => $this->complemento,
                'cep' => $this->cep,
                'cidade' => $this->cidade,
                'uf' => $this->uf,
                'canais' => $this->canais,
                'vencimento' => $this->vencimento,
                'valor_plano' => $this->valor_plano,
                'franquia_minutos' => $this->franquia_minutos,
                'valor_excedente' => $this->valor_excedente,
                'data_inicio' => $this->data_inicio,
                'data_fim' => $this->data_fim,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'senha' => $this->password,
                'ativo' => $this->ativo,
            ]);

            // Criação do User
            User::updateOrCreate(
                ['email' => 'cliente@'.$this->cnpj],
                [
                    'customer_id' => $this->contrato, // Use o ID do Customer recém-criado
                    //'name' => $this->razaosocial,
                    'password' => bcrypt($this->password),
                    //'rule' => 'customer',
                    //'ativo' => $this->ativo,
                ]
            );

            DB::commit(); // Confirma a transação se tudo der certo

            $this->toast()->success('Usuário e cliente atualizados com sucesso!')->send();

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack(); // Reverte todas as operações se algo falhar
            Log::error('Erro ao criar usuário ou cliente: '.$e->getMessage()); // Registra o erro
            $this->slide = false;
            $this->toast()->error('Erro ao criar o Usuário ou Cliente!')->send();
        }

        $this->cancel();
    }

    protected function normalizeData()
    {
        $this->resetValidation();
        // Normalização dos dados
        $this->cnpj = str_replace(['.', '/', '-'], '', $this->cnpj);
        $this->cep = str_replace(['.', '/', '-'], '', $this->cep);
        $this->valor_plano = str_replace(',', '.', $this->valor_plano);
        $this->valor_plano = preg_replace('/\.(?=.*\.)/', '', $this->valor_plano);
        $this->valor_plano = number_format($this->valor_plano, 2, '.', '');
        $this->franquia_minutos = str_replace([',', '.'], '', $this->franquia_minutos);

    }

    protected function apresentationData()
    {
        // Normalização dos dados
        $this->valor_plano = number_format($this->valor_plano, 2, '.', '');
        $this->telefone = preg_replace(
            '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
            '($1$4) $2$5-$3$6',
            $this->telefone
        );

        $this->cep = preg_replace(
            '/^(\d{5})(\d{3})$/',
            '$1-$2',
            $this->cep
        );
        $this->cnpj = preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $this->cnpj
        );
    }

    public function cancel()
    {
        $this->resetValidation();
        $this->dispatch('table-update');
        $this->reset(['contrato', 'cnpj', 'razaosocial', 'nomefantasia', 'endereco', 'numero', 'complemento', 'cidade',
            'uf', 'cep', 'canais', 'valor_plano', 'franquia_minutos', 'valor_excedente', 'data_inicio', 'data_fim', 'email',
            'telefone', 'password', ]);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.customers.update');
    }
}
