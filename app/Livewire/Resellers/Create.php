<?php

namespace App\Livewire\Resellers;

use App\Models\Reseller;
use Livewire\Attributes\Layout;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class Create extends Component
{
    use Interactions;

    // Informações Básicas
    public $nome = '';
    public $razao_social = '';
    public $cnpj = '';
    public $email = '';
    public $telefone = '';

    // Endereço
    public $endereco = '';
    public $numero = '';
    public $complemento = '';
    public $cidade = '';
    public $uf = '';
    public $cep = '';

    // Markups (percentual)
    public $markup_chamadas = 0;
    public $markup_produtos = 0;
    public $markup_planos = 0;
    public $markup_dids = 0;

    // Valores Fixos (opcional)
    public $valor_fixo_chamada = null;
    public $valor_fixo_produto = null;
    public $valor_fixo_plano = null;
    public $valor_fixo_did = null;

    // Controle
    public $ativo = true;
    public $observacoes = '';

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:18|unique:resellers,cnpj',
            'email' => 'required|email|unique:resellers,email',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
            'markup_chamadas' => 'required|numeric|min:0|max:100',
            'markup_produtos' => 'required|numeric|min:0|max:100',
            'markup_planos' => 'required|numeric|min:0|max:100',
            'markup_dids' => 'required|numeric|min:0|max:100',
            'valor_fixo_chamada' => 'nullable|numeric|min:0',
            'valor_fixo_produto' => 'nullable|numeric|min:0',
            'valor_fixo_plano' => 'nullable|numeric|min:0',
            'valor_fixo_did' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
        ];
    }

    protected $messages = [
        'nome.required' => 'O nome é obrigatório',
        'email.required' => 'O e-mail é obrigatório',
        'email.email' => 'E-mail inválido',
        'email.unique' => 'Este e-mail já está cadastrado',
        'cnpj.unique' => 'Este CNPJ já está cadastrado',
        'markup_chamadas.required' => 'Informe o markup de chamadas',
        'markup_chamadas.min' => 'Markup mínimo é 0%',
        'markup_chamadas.max' => 'Markup máximo é 100%',
    ];

    public function save()
    {
        $this->validate();

        try {
            Reseller::create([
                'nome' => $this->nome,
                'razao_social' => $this->razao_social,
                'cnpj' => $this->cnpj,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'endereco' => $this->endereco,
                'numero' => $this->numero,
                'complemento' => $this->complemento,
                'cidade' => $this->cidade,
                'uf' => $this->uf,
                'cep' => $this->cep,
                'markup_chamadas' => $this->markup_chamadas,
                'markup_produtos' => $this->markup_produtos,
                'markup_planos' => $this->markup_planos,
                'markup_dids' => $this->markup_dids,
                'valor_fixo_chamada' => $this->valor_fixo_chamada,
                'valor_fixo_produto' => $this->valor_fixo_produto,
                'valor_fixo_plano' => $this->valor_fixo_plano,
                'valor_fixo_did' => $this->valor_fixo_did,
                'ativo' => $this->ativo,
                'data_cadastro' => now(),
                'observacoes' => $this->observacoes,
            ]);

            $this->toast()->success('Revenda cadastrada com sucesso!')->send();

            return redirect()->route('config.reseller');
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao cadastrar revenda: ' . $e->getMessage())->send();
        }
    }

    public function render()
    {
        return view('livewire.resellers.create');
    }
}
