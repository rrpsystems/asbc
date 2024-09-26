<?php

namespace App\Livewire\Dids;

use App\Models\Did;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $did;

    private $msg_error = 'Erro ao excluir o Numero!';

    private $msg_success = 'Numero excluido com sucesso!';

    private $msg_confirm = 'Deseja excluir este Numero?';

    #[On('did-delete')]
    public function save($id): void
    {
        $this->did = Did::find($id);
        $this->toast()
            ->timeout(seconds: 10)
            ->question($this->did->did = preg_replace(
                '/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/',
                '($1$4) $2$5-$3$6',
                $this->did->did
            ), $this->msg_confirm)
            ->cancel('Confirmar', 'confirmed', $this->msg_success)
            //->cancel('Cancelar', 'cancelled', 'Cancelled Successfully')
            ->send();
    }

    public function confirmed(string $message): void
    {
        try {
            $this->did->delete();
            $this->dispatch('table-update');
        } catch (\Exception $e) {
            Log::error($this->msg_error.' Erro: '.$e->getMessage()); // Registra o erro
            //$this->toast()->error($e->getMessage());
            $this->toast()->error($this->msg_error)->send();

            return;
        }

        $this->toast()->success($message)->send();
    }

    public function cancelled(string $message): void {}

    public function render()
    {
        return view('livewire.dids.delete');

    }
}
