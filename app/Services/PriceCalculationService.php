<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Reseller;
use Illuminate\Support\Facades\Log;

class PriceCalculationService
{
    /**
     * Calcula preço com markup baseado no tipo de serviço
     *
     * @param float $basePrice Preço base (seu preço de venda, SEM markup)
     * @param Customer $customer Cliente
     * @param string $serviceType Tipo: 'chamadas', 'produtos', 'planos', 'dids'
     * @return float Preço final com markup aplicado (se houver revenda)
     */
    public function calculatePrice(float $basePrice, Customer $customer, string $serviceType = 'chamadas'): float
    {
        // Se cliente NÃO tem revenda, retorna preço normal (sem markup)
        if (!$customer->hasReseller()) {
            return $basePrice;
        }

        $reseller = $customer->reseller;

        // Aplica o markup da revenda
        return $reseller->applyMarkup($basePrice, $serviceType);
    }

    /**
     * Calcula preço com markup usando apenas o reseller_id
     * Útil quando você tem apenas o ID e não quer carregar o Customer completo
     *
     * @param float $basePrice Preço base
     * @param int|null $resellerId ID da revenda
     * @param string $serviceType Tipo de serviço
     * @return float Preço com markup
     */
    public function calculatePriceByResellerId(float $basePrice, ?int $resellerId, string $serviceType = 'chamadas'): float
    {
        // Se não tem revenda, retorna preço normal
        if (!$resellerId) {
            return $basePrice;
        }

        $reseller = Reseller::find($resellerId);

        if (!$reseller) {
            Log::warning('Reseller not found', ['reseller_id' => $resellerId]);
            return $basePrice;
        }

        return $reseller->applyMarkup($basePrice, $serviceType);
    }

    /**
     * Retorna informações detalhadas sobre o markup aplicado
     *
     * @param Customer $customer Cliente
     * @param string $serviceType Tipo de serviço
     * @return array Informações do markup
     */
    public function getMarkupInfo(Customer $customer, string $serviceType): array
    {
        if (!$customer->hasReseller()) {
            return [
                'has_markup' => false,
                'markup_percent' => 0,
                'is_fixed_value' => false,
                'fixed_value' => null,
                'reseller_name' => null,
            ];
        }

        return $customer->reseller->getMarkupInfo($serviceType);
    }

    /**
     * Calcula breakdown detalhado de preço (para faturas, relatórios, etc)
     *
     * @param float $basePrice Preço base
     * @param Customer $customer Cliente
     * @param string $serviceType Tipo de serviço
     * @return array Breakdown com custos, markup, preço final
     */
    public function getPriceBreakdown(float $basePrice, Customer $customer, string $serviceType = 'chamadas'): array
    {
        $markupInfo = $this->getMarkupInfo($customer, $serviceType);
        $finalPrice = $this->calculatePrice($basePrice, $customer, $serviceType);

        $markupValue = $finalPrice - $basePrice;
        $markupPercent = $basePrice > 0 ? ($markupValue / $basePrice) * 100 : 0;

        return [
            'base_price' => $basePrice,
            'markup_value' => $markupValue,
            'markup_percent' => $markupPercent,
            'final_price' => $finalPrice,
            'has_reseller' => $customer->hasReseller(),
            'reseller_name' => $customer->reseller->nome ?? null,
            'markup_info' => $markupInfo,
        ];
    }

    /**
     * Calcula preço reverso (dado o preço final, calcula o preço base)
     * Útil para relatórios da revenda
     *
     * @param float $finalPrice Preço final (com markup)
     * @param Reseller $reseller Revenda
     * @param string $serviceType Tipo de serviço
     * @return float Preço base (sem markup)
     */
    public function calculateReversePrice(float $finalPrice, Reseller $reseller, string $serviceType = 'chamadas'): float
    {
        $fixedField = "valor_fixo_{$serviceType}";
        $markupField = "markup_{$serviceType}";

        // Se tem valor fixo, não dá pra calcular reverso de forma precisa
        if (isset($reseller->$fixedField) && $reseller->$fixedField > 0) {
            return 0; // Ou lançar exception
        }

        $markup = $reseller->$markupField ?? 0;

        if ($markup == 0) {
            return $finalPrice;
        }

        // Fórmula: basePrice = finalPrice / (1 + markup/100)
        return $finalPrice / (1 + ($markup / 100));
    }

    /**
     * Calcula lucro da revenda para um valor
     *
     * @param float $basePrice Preço base (o que você cobra)
     * @param Customer $customer Cliente
     * @param string $serviceType Tipo de serviço
     * @return float Lucro da revenda (markup em R$)
     */
    public function calculateResellerProfit(float $basePrice, Customer $customer, string $serviceType = 'chamadas'): float
    {
        if (!$customer->hasReseller()) {
            return 0;
        }

        $finalPrice = $this->calculatePrice($basePrice, $customer, $serviceType);

        return $finalPrice - $basePrice;
    }
}
