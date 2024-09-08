<?php

namespace App\Services;

class InstallmentService
{
    public function createInstallments($total, $numInstallments)
    {
        $installments = [];
        $installmentValue = $total / $numInstallments;

        for ($i = 1; $i <= $numInstallments; $i++) {
            $installments[] = [
                'number' => $i,
                'value' => $installmentValue,
                'expiration_date' => now()->addMonths($i),
                'paid' => false,
            ];
        }

        return $installments;
    }

    

    public function adjustInstallments($installments, $alteredInstallment, $newValue, $total)
    {
        $installments[$alteredInstallment - 1]['value'] = $newValue;

        $sumUpToAltered = array_sum(array_column(array_slice($installments, 0, $alteredInstallment), 'value'));

        for ($i = $alteredInstallment; $i < count($installments); $i++) {
            $remainingValue = ($total - $sumUpToAltered) / (count($installments) - $i);
            $installments[$i]['value'] = $remainingValue;
        }

        return $installments;
    }
}
