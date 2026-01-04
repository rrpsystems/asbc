<?php

namespace App\Livewire\Resellers;

use App\Models\Reseller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Settings extends Component
{
    use Interactions;

    public $reseller;

    // Markups percentuais
    public $markup_chamadas = 0;
    public $markup_produtos = 0;
    public $markup_planos = 0;
    public $markup_dids = 0;

    // Valores fixos opcionais (sobrescreve markup %)
    public $valor_fixo_chamadas;
    public $valor_fixo_produtos;
    public $valor_fixo_planos;
    public $valor_fixo_dids;

    public function mount()
    {
        // Carrega a revenda do usuário logado
        $user = Auth::user();

        if (!$user->reseller_id) {
            abort(403, 'Usuário não está associado a uma revenda');
        }

        $this->reseller = Reseller::findOrFail($user->reseller_id);

        // Carrega valores atuais
        $this->markup_chamadas = $this->reseller->markup_chamadas ?? 0;
        $this->markup_produtos = $this->reseller->markup_produtos ?? 0;
        $this->markup_planos = $this->reseller->markup_planos ?? 0;
        $this->markup_dids = $this->reseller->markup_dids ?? 0;

        $this->valor_fixo_chamadas = $this->reseller->valor_fixo_chamadas;
        $this->valor_fixo_produtos = $this->reseller->valor_fixo_produtos;
        $this->valor_fixo_planos = $this->reseller->valor_fixo_planos;
        $this->valor_fixo_dids = $this->reseller->valor_fixo_dids;
    }

    public function save()
    {
        $this->validate([
            'markup_chamadas' => 'required|numeric|min:0|max:1000',
            'markup_produtos' => 'required|numeric|min:0|max:1000',
            'markup_planos' => 'required|numeric|min:0|max:1000',
            'markup_dids' => 'required|numeric|min:0|max:1000',
            'valor_fixo_chamadas' => 'nullable|numeric|min:0',
            'valor_fixo_produtos' => 'nullable|numeric|min:0',
            'valor_fixo_planos' => 'nullable|numeric|min:0',
            'valor_fixo_dids' => 'nullable|numeric|min:0',
        ]);

        $this->reseller->update([
            'markup_chamadas' => $this->markup_chamadas,
            'markup_produtos' => $this->markup_produtos,
            'markup_planos' => $this->markup_planos,
            'markup_dids' => $this->markup_dids,
            'valor_fixo_chamadas' => $this->valor_fixo_chamadas,
            'valor_fixo_produtos' => $this->valor_fixo_produtos,
            'valor_fixo_planos' => $this->valor_fixo_planos,
            'valor_fixo_dids' => $this->valor_fixo_dids,
        ]);

        $this->toast()
            ->success('Configurações atualizadas com sucesso!')
            ->send();
    }

    public function render()
    {
        return view('livewire.resellers.settings');
    }
}
