<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura Resumida #{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 3px solid #2563EB; padding-bottom: 15px; }
        .logo { width: 120px; }
        .company-info h1 { font-size: 18px; color: #2563EB; margin-bottom: 5px; font-weight: bold; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { font-size: 24px; font-weight: bold; color: #2563EB; }
        .invoice-info .invoice-number { font-size: 14px; color: #666; margin-top: 5px; }
        .invoice-info .invoice-type { font-size: 10px; color: #16a34a; font-weight: bold; margin-top: 3px; }
        .billing-info { display: flex; justify-content: space-between; margin-bottom: 25px; background-color: #f9fafb; padding: 15px; border-radius: 5px; }
        .billing-to, .invoice-details { width: 48%; }
        h3 { font-size: 13px; font-weight: bold; margin-bottom: 8px; color: #2563EB; }
        .address { font-size: 10px; line-height: 1.6; color: #666; }

        /* Plan Summary Box */
        .plan-summary { background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .plan-summary h3 { color: white; font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 5px; }
        .plan-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .plan-item { text-align: center; padding: 8px; background-color: rgba(255,255,255,0.1); border-radius: 5px; }
        .plan-item .label { font-size: 9px; opacity: 0.9; margin-bottom: 3px; }
        .plan-item .value { font-size: 13px; font-weight: bold; }

        /* DIDs Section */
        .dids-section { margin-bottom: 20px; background-color: #f9fafb; padding: 12px; border-radius: 5px; border-left: 4px solid #2563EB; }
        .dids-section h3 { font-size: 12px; margin-bottom: 8px; }
        .dids-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .did-item { font-size: 10px; background-color: white; padding: 4px 8px; border-radius: 3px; border: 1px solid #d1d5db; }

        /* Summary Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table { border: 2px solid #2563EB; border-radius: 5px; overflow: hidden; }
        thead { background-color: #2563EB; color: white; }
        th { padding: 10px 8px; text-align: left; font-size: 11px; font-weight: bold; }
        td { padding: 10px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        tbody tr:hover { background-color: #f3f4f6; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }

        /* Totals Section */
        .totals-section { background-color: #f9fafb; border: 2px solid #e5e7eb; border-radius: 8px; padding: 15px; margin-top: 20px; }
        .totals-section h3 { color: #2563EB; margin-bottom: 12px; }
        .totals dl { display: flex; justify-content: space-between; margin-bottom: 8px; padding: 6px 0; border-bottom: 1px solid #e5e7eb; }
        .totals dt { font-weight: normal; color: #666; }
        .totals dd { font-weight: bold; color: #333; }
        .totals .total-line { border-bottom: none; border-top: 2px solid #2563EB; padding-top: 10px; margin-top: 5px; }
        .totals .total-line dt { font-size: 14px; font-weight: bold; color: #2563EB; }
        .totals .total-line dd { font-size: 16px; font-weight: bold; color: #16a34a; }
        .excedente { color: #ea580c; }

        /* Footer */
        .footer { margin-top: 30px; border-top: 2px solid #e5e7eb; padding-top: 15px; text-align: center; }
        .footer p { font-size: 9px; color: #666; margin-bottom: 3px; }
        .footer .highlight { color: #2563EB; font-weight: bold; }

        /* Notes */
        .notes { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 10px; margin-top: 15px; border-radius: 3px; }
        .notes p { font-size: 9px; color: #92400e; line-height: 1.4; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>RRP Systems Ltda.</h1>
                <p class="address">
                    Av. Pedro Lessa, 3076 - Conj. 71<br>
                    Santos/SP - CEP: 11025-002<br>
                    CNPJ: 00.000.000/0000-00<br>
                    contato@rrpsystems.com.br | (13) 2191-2121
                </p>
            </div>
            <div class="invoice-info">
                <h2>FATURA</h2>
                <p class="invoice-number">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="invoice-type">RESUMIDA</p>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="billing-info">
            <div class="billing-to">
                <h3>Faturado para:</h3>
                <p><strong>{{ $invoice->customer->razaosocial ?? '' }}</strong></p>
                @if($invoice->customer->nomefantasia && $invoice->customer->nomefantasia != $invoice->customer->razaosocial)
                    <p style="font-size: 9px; color: #666;">{{ $invoice->customer->nomefantasia }}</p>
                @endif
                <p class="address">
                    {{ $invoice->customer->endereco ?? '' }}, {{ $invoice->customer->numero ?? '' }}
                    {{ $invoice->customer->complemento ? '- ' . $invoice->customer->complemento : '' }}<br>
                    {{ $invoice->customer->cidade ?? '' }}/{{ $invoice->customer->uf ?? '' }} -
                    {{ preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $invoice->customer->cep ?? '') }}<br>
                    CNPJ/CPF: {{ $invoice->customer->cnpj ?? 'N/A' }}
                </p>
            </div>
            <div class="invoice-details">
                <h3>Detalhes da Fatura:</h3>
                <p><strong>Competência:</strong> {{ str_pad($invoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $invoice->ano }}</p>
                <p><strong>Emissão:</strong> {{ date('d/m/Y') }}</p>
                <p><strong>Vencimento:</strong> {{ $invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano) }}</p>
                <p style="margin-top: 8px;"><strong>Status:</strong>
                    <span style="color: {{ $invoice->fechado ? '#16a34a' : '#f59e0b' }}; font-weight: bold;">
                        {{ $invoice->fechado ? 'FECHADA' : 'ABERTA' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Plan Summary -->
        <div class="plan-summary">
            <h3>RESUMO DO PLANO</h3>
            <div class="plan-grid">
                <div class="plan-item">
                    <div class="label">Números Ativos</div>
                    <div class="value">{{ count($dids) }}</div>
                </div>
                <div class="plan-item">
                    <div class="label">Valor do Plano</div>
                    <div class="value">R$ {{ number_format($invoice->valor_plano, 2, ',', '.') }}</div>
                </div>
                <div class="plan-item">
                    <div class="label">Franquia (minutos)</div>
                    <div class="value">{{ number_format(ceil($invoice->franquia_minutos / 60), 0, ',', '.') }}</div>
                </div>
                <div class="plan-item">
                    <div class="label">Fixo (minutos)</div>
                    <div class="value">{{ number_format(ceil($invoice->minutos_fixo / 60), 0, ',', '.') }}</div>
                </div>
                <div class="plan-item">
                    <div class="label">Móvel (minutos)</div>
                    <div class="value">{{ number_format(ceil($invoice->minutos_movel / 60), 0, ',', '.') }}</div>
                </div>
                <div class="plan-item">
                    <div class="label">Excedente (minutos)</div>
                    <div class="value" style="color: {{ $invoice->minutos_excedentes > 0 ? '#fbbf24' : 'white' }};">
                        {{ number_format(ceil($invoice->minutos_excedentes / 60), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- DIDs -->
        <div class="dids-section">
            <h3>Seus Números ({{ count($dids) }}):</h3>
            <div class="dids-list">
                @foreach ($dids as $did)
                    <span class="did-item">{{ preg_replace('/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->did) }}</span>
                @endforeach
            </div>
        </div>

        <!-- Calls Summary Table -->
        <h3 style="margin-bottom: 10px; font-size: 14px;">RESUMO DE CHAMADAS POR TIPO</h3>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>TIPO DE CHAMADA</th>
                    <th class="text-center">QUANTIDADE</th>
                    <th class="text-center">MINUTOS</th>
                    <th class="text-right">VALOR TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalChamadas = 0;
                    $totalMinutos = 0;
                    $totalValor = 0;
                @endphp
                @foreach ($callsSummary as $summary)
                    @php
                        $totalChamadas += $summary->quantidade;
                        $totalMinutos += $summary->total_segundos;
                        $totalValor += $summary->valor_total;
                    @endphp
                    <tr>
                        <td><strong>{{ $summary->tarifa }}</strong></td>
                        <td class="text-center">{{ number_format($summary->quantidade, 0, '.', '.') }}</td>
                        <td class="text-center">{{ number_format(ceil($summary->total_segundos / 60), 0, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format($summary->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #e0e7ff; font-weight: bold; border-top: 2px solid #2563EB;">
                    <td><strong>TOTAL</strong></td>
                    <td class="text-center"><strong>{{ number_format($totalChamadas, 0, '.', '.') }}</strong></td>
                    <td class="text-center"><strong>{{ number_format(ceil($totalMinutos / 60), 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>R$ {{ number_format($totalValor, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <h3>VALORES DA FATURA</h3>
            <dl>
                <dt>Valor do Plano:</dt>
                <dd>R$ {{ number_format($invoice->valor_plano, 2, ',', '.') }}</dd>
            </dl>

            @if($invoice->excedente_fixo > 0)
            <dl>
                <dt>Excedente Fixo:</dt>
                <dd class="excedente">R$ {{ number_format($invoice->excedente_fixo, 2, ',', '.') }}</dd>
            </dl>
            @endif

            @if($invoice->excedente_movel > 0)
            <dl>
                <dt>Excedente Móvel:</dt>
                <dd class="excedente">R$ {{ number_format($invoice->excedente_movel, 2, ',', '.') }}</dd>
            </dl>
            @endif

            @if($invoice->excedente_internacional > 0)
            <dl>
                <dt>Excedente Internacional:</dt>
                <dd class="excedente">R$ {{ number_format($invoice->excedente_internacional, 2, ',', '.') }}</dd>
            </dl>
            @endif

            @if($invoice->custo_excedente > 0)
            <dl>
                <dt>Total Excedentes:</dt>
                <dd class="excedente">R$ {{ number_format($invoice->custo_excedente, 2, ',', '.') }}</dd>
            </dl>
            @endif

            <dl class="total-line">
                <dt>TOTAL DA FATURA:</dt>
                <dd>R$ {{ number_format($invoice->custo_total, 2, ',', '.') }}</dd>
            </dl>
        </div>

        <!-- Notes -->
        <div class="notes">
            <p><strong>Observações:</strong> Esta é uma fatura resumida contendo apenas o consolidado por tipo de chamada. Para visualizar o detalhamento completo de cada ligação, solicite a versão detalhada da fatura.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="highlight">RRP Systems Ltda.</p>
            <p>Av. Pedro Lessa, 3076 - Conj. 71 - Santos/SP - CEP: 11025-002</p>
            <p>Telefone: (13) 2191-2121 | E-mail: contato@rrpsystems.com.br</p>
            <p style="margin-top: 10px;">© {{ date('Y') }} RRP Systems Ltda. - Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
