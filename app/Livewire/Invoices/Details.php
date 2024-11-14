<?php

namespace App\Livewire\Invoices;

use App\Models\Cdr;
use App\Models\Did;
use App\Models\RevenueSummary;
use Livewire\Component;

class Details extends Component
{
    public $invoiceId;

    public $invoice;

    public $dids;

    // public $calls;

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        $this->invoice = RevenueSummary::with('customer')->where('id', $invoiceId)->first();
        $this->dids = Did::where('customer_id', $this->invoice->customer_id)->get();
    }

    public function render()
    {
        //dd($this->invoice);
        $calls = Cdr::where('customer_id', $this->invoice->customer_id)
            ->where('tempo_cobrado', '>', '1')
            //->where('tarifa', 'Internacional')
            ->whereMonth('calldate', $this->invoice->mes)
            ->whereYear('calldate', $this->invoice->ano)
            ->get()->groupBy('tarifa');

        return view('livewire.invoices.details', [
            'calls' => $calls,
        ]);
    }
}
