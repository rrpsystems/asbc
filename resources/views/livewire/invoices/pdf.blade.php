<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura #{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #2563EB; padding-bottom: 15px; }
        .logo { width: 120px; }
        .company-info h1 { font-size: 18px; color: #2563EB; margin-bottom: 5px; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { font-size: 22px; font-weight: bold; color: #333; }
        .invoice-info .invoice-number { font-size: 14px; color: #666; margin-top: 5px; }
        .billing-info { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .billing-to, .invoice-details { width: 48%; }
        h3 { font-size: 13px; font-weight: bold; margin-bottom: 8px; color: #2563EB; }
        .address { font-size: 10px; line-height: 1.6; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        thead { background-color: #2563EB; color: white; }
        th { padding: 8px; text-align: left; font-size: 10px; font-weight: bold; }
        td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        .summary-box { border: 1px solid #d1d5db; border-radius: 5px; padding: 12px; margin-bottom: 15px; background-color: #f9fafb; }
        .summary-box p { margin-bottom: 5px; font-size: 10px; }
        .summary-box strong { color: #2563EB; }
        .totals { text-align: right; margin-top: 20px; }
        .totals dl { display: flex; justify-content: flex-end; margin-bottom: 5px; }
        .totals dt { margin-right: 10px; font-weight: normal; min-width: 150px; text-align: right; }
        .totals dd { font-weight: bold; min-width: 100px; }
        .total-line { border-top: 2px solid #333; padding-top: 8px; margin-top: 8px; }
        .total-line dt, .total-line dd { font-size: 14px; color: #16a34a; }
        .footer { margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 15px; font-size: 9px; color: #666; }
        .section-title { background-color: #2563EB; color: white; padding: 6px 10px; margin-top: 15px; margin-bottom: 8px; font-size: 11px; font-weight: bold; }
        .dids-list { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px; }
        .did-item { font-size: 9px; color: #666; }
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
                    Santos/SP<br>
                    contato@rrpsystems.com.br | (13) 2191-2121
                </p>
            </div>
            <div class="invoice-info">
                <h2>FATURA</h2>
                <p class="invoice-number">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="billing-info">
            <div class="billing-to">
                <h3>Faturado para:</h3>
                <p><strong>{{ $invoice->customer->razaosocial ?? '' }}</strong></p>
                <p class="address">
                    {{ $invoice->customer->endereco ?? '' }}, {{ $invoice->customer->numero ?? '' }}
                    {{ $invoice->customer->complemento ? '- ' . $invoice->customer->complemento : '' }}<br>
                    {{ $invoice->customer->cidade ?? '' }}/{{ $invoice->customer->uf ?? '' }} -
                    {{ preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $invoice->customer->cep ?? '') }}
                </p>
            </div>
            <div class="invoice-details">
                <h3>Detalhes da Fatura:</h3>
                <p><strong>Competência:</strong> {{ str_pad($invoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $invoice->ano }}</p>
                <p><strong>Vencimento:</strong> {{ $invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano) }}</p>
            </div>
        </div>

        <!-- Summary Box -->
        <div class="summary-box">
            <table>
                <tr>
                    <td><strong>Números(s):</strong> {{ count($dids) }}</td>
                    <td><strong>Valor Plano:</strong> R$ {{ number_format($invoice->valor_plano, 2, ',', '.') }}</td>
                    <td><strong>Minutos Franquia:</strong> {{ number_format(ceil($invoice->franquia_minutos / 60), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Fixo:</strong> {{ number_format(ceil($invoice->minutos_fixo / 60), 0, ',', '.') }} min</td>
                    <td><strong>Móvel:</strong> {{ number_format(ceil($invoice->minutos_movel / 60), 0, ',', '.') }} min</td>
                    <td><strong>Excedente:</strong> {{ number_format(ceil($invoice->minutos_excedentes / 60), 0, ',', '.') }} min</td>
                </tr>
            </table>
        </div>

        <!-- DIDs -->
        <h3>Seus Números:</h3>
        <div class="dids-list">
            @foreach ($dids as $did)
                <span class="did-item">{{ preg_replace('/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->did) }}</span>
            @endforeach
        </div>

        <!-- Consolidated Summary Table -->
        @if(isset($callsSummary) && count($callsSummary) > 0)
        <div class="section-title">RESUMO CONSOLIDADO POR TIPO DE CHAMADA</div>
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>TIPO</th>
                    <th style="text-align: center;">QUANTIDADE</th>
                    <th style="text-align: center;">MINUTOS</th>
                    <th style="text-align: right;">VALOR TOTAL</th>
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
                        <td style="text-align: center;">{{ number_format($summary->quantidade, 0, '.', '.') }}</td>
                        <td style="text-align: center;">{{ number_format(ceil($summary->total_segundos / 60), 0, ',', '.') }}</td>
                        <td style="text-align: right;">R$ {{ number_format($summary->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #e0e7ff; font-weight: bold;">
                    <td><strong>TOTAL</strong></td>
                    <td style="text-align: center;"><strong>{{ number_format($totalChamadas, 0, '.', '.') }}</strong></td>
                    <td style="text-align: center;"><strong>{{ number_format(ceil($totalMinutos / 60), 0, ',', '.') }}</strong></td>
                    <td style="text-align: right;"><strong>R$ {{ number_format($totalValor, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title" style="background-color: #16a34a;">DETALHAMENTO COMPLETO DAS CHAMADAS</div>
        @endif

        <!-- Calls by Type -->
        @foreach ($calls as $tarifa => $data)
            <div class="section-title">{{ $tarifa }}</div>
            <table>
                <thead>
                    <tr>
                        <th>DATA</th>
                        <th>HORA</th>
                        <th>DURAÇÃO</th>
                        <th>ORIGEM</th>
                        <th>RAMAL</th>
                        <th>TELEFONE</th>
                        <th>VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $call)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($call->calldate)) }}</td>
                            <td>{{ date('H:i', strtotime($call->calldate)) }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('U', $call->tempo_cobrado ?? '0')->format('H\hi\ms\s') }}</td>
                            <td>{{ $call->did_id }}</td>
                            <td>{{ $call->ramal }}</td>
                            <td>{{ $call->numero }}</td>
                            <td>{{ strtoupper($call->cobrada) == 'S' ? 'R$ ' . number_format($call->valor_venda, 2, ',', '.') : 'R$ 0,00' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <!-- Totals -->
        <div class="totals">
            <dl>
                <dt>Valor Plano:</dt>
                <dd>R$ {{ number_format($invoice->valor_plano, 2, ',', '.') }}</dd>
            </dl>

            @if($invoice->excedente_fixo > 0)
            <dl>
                <dt>Excedente Fixo:</dt>
                <dd style="color: #ea580c;">R$ {{ number_format($invoice->excedente_fixo, 2, ',', '.') }}</dd>
            </dl>
            @endif

            @if($invoice->excedente_movel > 0)
            <dl>
                <dt>Excedente Móvel:</dt>
                <dd style="color: #ea580c;">R$ {{ number_format($invoice->excedente_movel, 2, ',', '.') }}</dd>
            </dl>
            @endif

            @if($invoice->excedente_internacional > 0)
            <dl>
                <dt>Excedente Internacional:</dt>
                <dd style="color: #ea580c;">R$ {{ number_format($invoice->excedente_internacional, 2, ',', '.') }}</dd>
            </dl>
            @endif

            <dl class="total-line">
                <dt>TOTAL DA FATURA:</dt>
                <dd>R$ {{ number_format($invoice->custo_total, 2, ',', '.') }}</dd>
            </dl>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} RRP Systems Ltda. - Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
